<?php
//* request runs it 
require_once __DIR__ . "/Database.php";
class Validation
{
    private array $data;
    /**
    ex)
    [
    'email'=>'asmaamaged96@gmail.com',
    'password'=>'123456677'
    ]
     */
    private array $rules;
    /**
    ex)
    [
    'product_id'=>['required',['exist','tableName','id']],
    //['unique','tableName'] unique for each table
    'email'=>['required','email',['unique','tableName']],
    'password'=>['required',['min',8]]
    ]
     */
    private array $error = [];
    /**
    ex)
    [
    'email'=>[
    'email is required',
    'email must to be valid email'
    ],

    'password'=>[
    'password is required',
    ],

    ]
     */
    public function __construct(array $data, array $rules)
    {
        $this->data  = $data;
        $this->rules = $rules;
    }
    public function validation(): array
    {

        foreach ($this->rules as $filed => $rules) {
            /**
            ex)
            [
            'filed'=>rules['    '],
            'filed'=>rules['   ',[ '' ,'' ]]
            ]
             */
            $value = $this->data[$filed] ?? null;
            /**
            ex) in data
            [
            'filed'=>'value',
            'filed'=>'value'
            ]
             */
            foreach ($rules as $rule) {

                if (is_string($rule)) {
                    if ($rule === 'required') {
                        $this->validationRequired($filed, $value);
                    } else if ($rule === 'email') {
                        $this->validationEmail($filed, $value);
                    } else if ($rule === 'EGPhone') {
                        $this->validationPhone($filed, $value);
                    }
                } else if (is_array($rule)) {
                    if ($rule[0] == "min") {
                        $this->validationMin($filed, $value, $rule[1]);
                    } else if ($rule[0] === 'unique') {
                        $this->validationUnique($filed, $value, $rule[1],$rule[2]);
                    } else if ($rule[0] === 'exists') {
                        $this->validationExists($filed, $value, $rule[1], $rule[2]);
                    }
                }
            }
        }
        return $this->error;
    }
    private function validationRequired(string $filed, mixed $value): void
    {
        if ($value === null || trim((string) $value) == "") {

            $this->addError($filed, "{$filed} is required");
        }
    }
    private function addError(string $filed, string $message): void
    {
        $this->error[$filed][] = $message;
        //*  [] means append
    }
    //*   " " is forbidden
    private function validationEmail(string $filed, mixed $value): void
    {
        if (empty($value)) {
            return;
        }
        $regex = "/^[A-Za-z_][A-Za-z_0-9\.\-]+@(gmail|yahoo)\.(com|org)$/";
        if (! preg_match($regex, $value)) {
            $this->addError($filed, "{$filed} must be valid Email");
        }
    }

    private function validationMin(string $filed, mixed $value, int $min = 8): void
    {
        if (empty($value)) {
            return;
        }
        if (strlen($value) < $min) {
            $this->addError($filed, "{$filed} must be at least {$min} characters");
        }
    }
    private function validationUnique(string $filed, mixed $value, string $table, mixed $exceptId = null): void
    {
        //* need to connect with DataBase
        $DB   = \Database::getConnection();

        $subquery = "";
        if ($exceptId !== null) {
            $subquery = "AND id !='{$exceptId}'";
        }
        $stat     = $DB->query("SELECT * 
                            FROM {$table} 
                            WHERE {$filed} = '{$value}' {$subquery};");
        $res  = $stat->fetchAll();

        if (! empty($res)) {
            $this->addError($filed, "is already exist");
        }
    }
    private function validationPhone(string $field, mixed $value)
    {
        if (empty($value)) {
            //* not my business :)
            return;
        }
        $regex = "/^(02)?01(0|1|2|5)[0-9]{8}$/";
        if (! preg_match($regex, $value)) {
            $this->addError($field, "{$field} must be valid Phone");
        }
    }
    private function validationExists(string $filed, mixed $value, string $table, string $columnName): void
    {
        //* need to connect with DataBase
        $DB   = \Database::getConnection();
        $stat = $DB->query("SELECT * FROM {$table} WHERE {$columnName}='{$value}'");
        $res  = $stat->fetchAll();
        if (empty($res)) {
            $this->addError($filed, "is not exist");
        }
    }
}
