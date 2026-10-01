let totalOrder = document.querySelector("#TotalOrders");

function addToCart(bookId, that) {
  let quantityValue = that.previousElementSibling.value,
    quantityInput = that.previousElementSibling;
  fetch("Profile/AddToCart", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      bookId: bookId,
      quantity: quantityValue,
    }),
  })
    .then(async (response) => {
      let data = await response.json();
      if (!response.ok) {
        throw data;
      }
      return data;
    })
    .then((respond) => {
      let stock = document.querySelector(`#BookStock-${bookId}`);
      console.log(respond);
      quantityInput.value = "";
      stock.innerHTML = respond.data[1];
      quantityInput?.blur();
      totalOrder.innerHTML = respond.data[0]["totalItemsIntoOrder"];
      isError(["success", respond.message]);
    })
    .catch((error) => {
      console.log(error.message);
      quantityInput.value = "";
      isError(["error", error.message]);
    });
}

function changeQuantityBtns(operator, bookId, orderItemId) {
  let QuantityInput = document.querySelector(`#CartInputInPopup-${bookId}`);
  if (operator == "+") {
    QuantityInput.value = Number(QuantityInput.value) + 1;
  } else if (QuantityInput.value > 1 && operator == "-") {
    QuantityInput.value = Number(QuantityInput.value) - 1;
  } else {
    DeleteItem(orderItemId, bookId);
  }
}

/* 
function updateQuantity:

      send order item id,quantity,BookId
          check
              validate order item id  required && exists
              Quantity is available with book stock
              BookID to Check the stock

      update stoke(orders),total price(Method),subtotal, quantity(orders_items) in DB

      respond stoke,total price,subtotal quantity

      update UI
          stoke in book card
          subtotal in cart cards 
          quantity ib cart cards 
          total  price in cart 
*/

function updateQuantity(orderItemId, oldQuantity, BookId) {
  let QuantityInput = document.querySelector(`#CartInputInPopup-${BookId}`),
    quantityValue = Number(QuantityInput.value),
    operation = "",
    deferenceQuantity = "";
  if (oldQuantity == quantityValue) {
    return;
  } else if (oldQuantity < quantityValue) {
    deferenceQuantity = quantityValue - oldQuantity;
    operation = "-";
  } else {
    deferenceQuantity = oldQuantity - quantityValue;
    operation = "+";
  }

  fetch("Profile/updateQuantity", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      bookId: BookId,
      quantity: quantityValue,
      operation: operation,
      deferenceQuantity: deferenceQuantity,
      orderItemId: orderItemId,
    }),
  })
    .then(async (response) => {
      let data = await response.json();
      if (!response.ok) {
        throw data;
      }
      return data;
    })
    .then((respond) => {
      console.log(respond);
      let TotalPriceInCart = document.querySelector("#TotalPriceInCart"),
        stockInCartBook = document.querySelector(`div[data-book-id="${BookId}"] .stock`),
        subtotalInCartBook = document.querySelector(`div[data-cart-item-id="${orderItemId}"] .subtotal`),
        quantityInCartBook = document.querySelector(`div[data-cart-item-id="${orderItemId}"] .quantity`);
      quantityValue = respond.data["returnQuantity"];
      TotalPriceInCart.innerHTML = respond.data["returnTotalPrice"];
      stockInCartBook.innerHTML = respond.data["returnStock"];
      subtotalInCartBook.innerHTML = respond.data["returnSubtotal"];
      quantityInCartBook.innerHTML = respond.data["returnQuantity"];
    })
    .catch((error) => {
      isError(["error", error.message]);
    });
}

/* 
Delete item

  send =>
      order item id , subtotal

  check =>
      validate order item id is exists

  update 
     delete order item 
     update total price 
*/

function DeleteItem(orderItemId, bookId) {
  let quantityInCartBook = document.querySelector(`div[data-cart-item-id="${orderItemId}"] .quantity`),
    quantity = Number(quantityInCartBook.textContent);

  fetch("Profile/DeleteItem", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      quantity: quantity,
      orderItemId: orderItemId,
      bookId: bookId,
    }),
  })
    .then(async (response) => {
      let data = await response.json();
      if (!response.ok) {
        throw data;
      }
      return data;
    })
    .then((respond) => {
      console.log(respond);

      let CartBook = document.querySelector(`div[data-cart-item-id="${orderItemId}"]`),
        TotalPriceInCartRow = document.querySelector(`#TotalPriceInCartRow`),
        popupContent = document.querySelector(`#CartModel .modal-body .row`),
        flag = 1;

      CartBook.remove();

      if (respond.data["returnTotalPrice"] == 0) {
        TotalPriceInCartRow.innerHTML = "";
        popupContent.innerHTML = "";
        flag = 0;
        popupContent.innerHTML = `
        <p class="alert alert-warning w-75 mx-auto text-center" >
         There No items in your Cart
        </p>
                `;
      } else {
        TotalPriceInCartRow.innerHTML = `Total Price :<span class="ms-2" id="TotalPriceInCart">${respond.data["returnTotalPrice"]}</span>`;
      }
      // if (respond.data["totalItemsIntoOrder"] == 1 && flag == 0) {
      //   popupContent.insertAdjacentHTML(
      //     "beforeend",
      //     `<button class="btn IdentityButton w-75 mx-auto" onclick='fireOrder()'>Order Now</button>`,
      //   );
      // }
      totalOrder.innerHTML = respond.data["totalItemsIntoOrder"];
      let stockInCartBook = document.querySelector(`div[data-book-id="${bookId}"] .stock`);
      stockInCartBook.innerHTML = respond.data["returnStock"];
    })
    .catch((error) => {
      console.log(error);
    });
}

function fireOrder() {
  fetch("Profile/fireOrder", {
    method: "POST",
  })
    .then(async (response) => {
      let data = await response.json();
      if (!response.ok) {
        throw data;
      }
      return data;
    })
    .then((respond) => {
      console.log(respond);
      isError(["success", "Order Make Successfully"]);

      let TotalPriceInCartRow = document.querySelector(`#TotalPriceInCartRow`),
        trInOrderedTable = document.querySelector("#orderedTable"),
        popupContent = document.querySelector(`#CartModel .modal-body .row`),
        closeBtn = document.querySelector("#CartModel .close");
      TotalPriceInCartRow.innerHTML = "";
      popupContent.innerHTML = "";
      closeBtn.click();
      totalOrder.innerHTML = 0;
      popupContent.innerHTML = `
        <p class="alert alert-warning w-75 mx-auto text-center" >
         There No items in your Cart
        </p>
                `;

      let adminControls =
        role == "admin"
          ? `
        <td>
            <button class="btn btn-info text-white">Done</button>
            <button class="btn btn-danger">Cancel</button>
        </td>
      `
          : "";

      trInOrderedTable.insertAdjacentHTML(
        "afterbegin",
        `
          <tr data-tr-order-id='${respond.data[0]["order_id"]}'>
                <td>${respond.data[0]["order_id"]}</td>
                <td>${respond.data[0]["customer_name"]}</td>
                <td>${respond.data[0]["total_price"]}</td>
                <td>
                    <a 
                        onclick='getItemsInCart(${respond.data[0]["order_id"]}, &quot;showOrder&quot;)'
                        style='cursor: pointer'
                    >
                        Show
                    </a>
                </td>                             
                <td>${respond.data[0]["created_at"]}</td>
                ${adminControls}
            
            </tr>
      `,
      );
      let WarningInOrderTable = document.querySelector("#WarningInOrderTable");
      WarningInOrderTable.remove();
    })
    .catch((error) => {
      console.log(error);
    });
}

/* 
Add tr of order on fireOrder 

cancel , Done

add update stock in admin
*/
