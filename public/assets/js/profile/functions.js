function isError(alert) {
  if (alert != null) {
    Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
      },
    }).fire({
      icon: alert[0],
      title: alert[1],
    });
  }
}
function imgPath(foldername, imageName) {
  return window.location.origin + `/assets/${foldername}/${imageName}`;
}

function route(path) {
  return window.location.origin + `/${path}`;
}

function shortBio(Bio) {
  if (Bio == "") {
    return "...";
  } else {
    return `${Bio}`;
  }
}

function showErrors(errors) {
  for (let error in errors) {
    let htmlError = document.querySelector(`p[data-error-name=${error}]`);
    htmlError.classList.remove("d-none");
    htmlError.innerHTML = `${errors[error][0]}`;
  }
}
function getItemsInCart(orderid = null, status = "cart") {
  fetch("Profile/GetCartData", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      orderid: orderid,
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
      let popupContent = document.querySelector(`#CartModel .modal-body .row`),
        TotalPriceInCartRow = document.querySelector(`#TotalPriceInCartRow`);
      popupContent.innerHTML = "";

      if (respond.data == 0) {
        TotalPriceInCartRow.innerHTML = "";
        popupContent.innerHTML = `
        <p class="alert alert-warning w-75 mx-auto text-center" >
         There No items in your Cart
        </p>
                `;
      } else {
        TotalPriceInCartRow.innerHTML = `Total Price :<span class="ms-2" id="TotalPriceInCart">${respond.data[0]["total_price"]}</span>`;
        if (status == "cart") {
          respond.data.forEach((book) => {
            popupContent.innerHTML += BookComponent(book, "cart");
          });
          popupContent.insertAdjacentHTML(
            "beforeend",
            `<button class="btn IdentityButton w-75 mx-auto" onclick='fireOrder()'>Order Now</button>`,
          );
        } else if (status == "showOrder") {
          respond.data.forEach((book) => {
            popupContent.innerHTML += BookComponent(book, "showOrder");
          });
        }
      }
      openPopup("CartModel");
    })
    .catch((error) => {
      console.log(error.message);
    });
}
function openPopup(popupId) {
  let popup = document.getElementById(popupId);
  const myModal = new bootstrap.Modal(popup);
  myModal.show();
  document.activeElement?.blur();
}
function BookComponent(book, type) {
  let imageFolder = book["image"] == null ? "images" : "upload",
    image = book["image"] == null ? "book.png" : book["image"],
    quantityInput =
      role === "customer"
        ? `<div class='input-group mb-3  position-absolute start-50 ' style='width: 90%; bottom:10px; transform:translateX(-50%);'>
                <input type='number' min='1' class='form-control' placeholder='Quantity' id='AddToCartInput-${book["id"]}'>
                <button class='btn IdentityButton' type='button' onclick='addToCart(${book["id"]},this)'>Add To Cart</button>
            </div>`
        : "";

  if (type == "cart") {
    return `
         <div class=" col-xl-4 col-lg-6 cart ${role}" data-cart-item-id="${book["order_items_id"]}">
                        <div class='box mb-3'>
                            <div class='item infoCard bookCard mainBg text-dark px-4 py-4 rounded-3 position-relative'>
                           <i class="fa-solid fa-trash text-danger position-absolute fs-5" style="top:20px; right:20px; cursor: pointer;" onclick='DeleteItem(${book["order_items_id"]}, ${book["book_id"]})'></i>
                                <div class='head text-center'>
                                    <div class='image mb-3 mx-auto' style='width:100px; '>
                                        <img
                                            src='${imgPath(imageFolder, image)}'
                                            alt=''
                                            class='img-fluid rounded-circle' />
                                    </div>

                                    <p class='fw-bold name' title='${book["title"]}'> <i class='fa-solid fa-book me-1' ></i>${book["title"]}</p>
                                </div>
                    <div class='boxData'>
                            <div class='item mb-3  '>
                                <div class='info d-flex  align-items-center flex-nowrap'>
                                    <h6 class='mb-0 fw-bold text-nowrap head w-100'><i class='fa-solid fa-feather me-1'></i>Author</h6>
                                </div>
                                <p class='content fw-bold mb-0 ms-1'>
                                   ${book["author_name"]}
                                </p>

                            </div>
                            <div class='item mb-3  '>
                                <div class='info d-flex  align-items-center flex-nowrap'>
                                    <h6 class='mb-0 fw-bold text-nowrap head w-100'>Description </h6>
                                </div>
                                <p class='content fw-bold mb-0 ms-1 px-1 disc' title='${shortBio(book["description"])}'>
                                ${shortBio(book["description"])}
                                </p>

                            </div>
                            <div class='additionalInfo d-flex w-100'>
                        <div class='item pb-1  w-100 borderline'>
                       <div class='info head flex-nowrap'>
                         <h6 class='mb-0 fw-bold text-nowrap'> <i class='fa-solid fa-tag me-1'></i>Price </h6>
                       </div>
                       <p class='content fw-bold mb-0'>
                           ${book["price"]}
                       </p>

                   </div>
                     <div class='item pb-1 w-100 '>
                       <div class='info head flex-nowrap'>
                           <h6 class='mb-0 fw-bold text-nowrap'><i class='fa-solid fa-tag me-1'></i>Subtotal </h6>
                       </div>
                       <p class='content subtotal fw-bold mb-0 ms-1'>
                           ${book["subtotal"]}
                       </p>

                   </div>
                      
                   
                   </div>
                          <div class='item m  '>
                       <div class='info head flex-nowrap'>
                           <h6 class='mb-0 fw-bold text-nowrap'> Quantity </h6>
                       </div>
                       <p class='content quantity fw-bold mb-0 ms-1'>
                           ${book["quantity"]}
                       </p>
                      
                      </div>
                   
                  

                      

                   </div>
                   <div class=" d-flex flex-nowrap">
                   <div class='input-group  mt-4 mx-auto' style="width: 150px;">
                        <button class='btn btn-outline-danger' type='button' onclick='changeQuantityBtns("-",${book["book_id"]},${book["order_items_id"]})'><i class="fa-solid fa-minus "></i></button>
                        <input type='text' disabled  value='${book["quantity"]}' class='form-control text-center' placeholder='Quantity' id='CartInputInPopup-${book["book_id"]}'>
                        <button class='btn btn-outline-success' type='button' onclick='changeQuantityBtns("+",${book["book_id"]},${book["order_items_id"]})'><i class="fa-solid fa-plus"></i></button>
                        </div>
                        <button
                            class='btn IdentityButton mt-4 mx-auto d-block text-nowrap'
                            type='button'
                            onclick='updateQuantity(${book["order_items_id"]}, ${book["quantity"]}, ${book["book_id"]})'
                        >
                            Update Item
                        </button>                
                      </div>
                   </div>

               </div>
          </div> 
      `;
  } else if (type == "filter") {
    return `
 <div class='col-xl-4 col-md-6 show ${role} ' data-book-id='${book["id"]}'>
                        <div class='box mb-3'>
                            <div class='item infoCard bookCard mainBg text-dark px-4 py-4 rounded-3 position-relative' data-book-id='${book['id']}''>

                                <div class='head text-center'>
                                    <div class='image mb-3 mx-auto'>
                                        <img
                                            src='${imgPath(imageFolder, image)}'
                                            alt=''
                                            class='img-fluid rounded-circle' />
                                    </div>

                                    <p class='fw-bold name' title='${book["title"]}'> <i class='fa-solid fa-book me-1' ></i>${book["title"]}</p>
                                </div>

                                <div class='boxData'>
                                <div class='item mb-3  '>
                                    <div class='info d-flex  align-items-center flex-nowrap'>
                                        <h6 class='mb-0 fw-bold text-nowrap head w-100'><i class='fa-solid fa-feather me-1'></i>Author</h6>
                                    </div>
                                    <p class='content fw-bold mb-0 ms-1'>
                                        ${book["author_name"]}
                                    </p>

                                </div>
                                <div class='item mb-3  '>
                                    <div class='info d-flex  align-items-center flex-nowrap'>
                                        <h6 class='mb-0 fw-bold text-nowrap head w-100'>Description </h6>
                                    </div>
                                    <p class='content fw-bold mb-0 ms-1 px-1 disc' title='${shortBio(book["description"])}'>
                                    ${shortBio(book["description"])}
                                    </p>

                                </div>
                               <div class='additionalInfo d-flex w-100'>
                                    <div class='item pb-1  w-100 borderline'>
                                        <div class='info  flex-nowrap head'>
                                            <h6 class='mb-0 fw-bold text-nowrap'> <i class='fa-solid fa-tag me-1'></i>Price </h6>
                                        </div>
                                        <p class='content fw-bold mb-0 '>
                                            ${book["price"]}
                                        </p>

                                    </div>
                                    <div class='item pb-1 w-100'>
                                        <div class='info  flex-nowrap head'>
                                            <h6 class='mb-0 fw-bold text-nowrap'><i class='fa-brands fa-codepen me-1'></i>Stoke  </h6>
                                        </div>
                                        <p class='content stock fw-bold mb-0 ' id='BookStock-${book["id"]}'>
                                           ${book["stock"]}

                                        </p>
                                    </div>
                                 ${quantityInput} 
                                </div>
                            </div>
                   </div>
               </div>
          </div> 

      `;
  } else if (type == "showOrder") {
    return `
         <div class=" col-xl-4 col-lg-6 showCart ${role}" data-cart-item-id="${book["order_items_id"]}">
                        <div class='box mb-3'>
                            <div class='item infoCard bookCard mainBg text-dark px-4 py-4 rounded-3 position-relative'>
                                <div class='head text-center'>
                                    <div class='image mb-3 mx-auto' style='width:100px; '>
                                        <img
                                            src='${imgPath(imageFolder, image)}'
                                            alt=''
                                            class='img-fluid rounded-circle' />
                                    </div>
                                                    <p class='fw-bold name' title='${book["title"]}'> <i class='fa-solid fa-book me-1' ></i>${book["title"]}</p>
                                </div>
                    <div class='boxData'>
                            <div class='item mb-3  '>
                                <div class='info d-flex  align-items-center flex-nowrap'>
                                    <h6 class='mb-0 fw-bold text-nowrap head w-100'><i class='fa-solid fa-feather me-1'></i>Author</h6>
                                </div>
                                <p class='content fw-bold mb-0 ms-1'>
                                   ${book["author_name"]}
                                </p>

                            </div>
                            <div class='item mb-3  '>
                                <div class='info d-flex  align-items-center flex-nowrap'>
                                    <h6 class='mb-0 fw-bold text-nowrap head w-100'>Description </h6>
                                </div>
                                <p class='content fw-bold mb-0 ms-1 px-1 disc' title='${shortBio(book["description"])}'>
                                ${shortBio(book["description"])}
                                </p>

                            </div>
                            <div class='additionalInfo d-flex w-100'>
                        <div class='item pb-1  w-100 borderline'>
                       <div class='info head flex-nowrap'>
                         <h6 class='mb-0 fw-bold text-nowrap'> <i class='fa-solid fa-tag me-1'></i>Price </h6>
                       </div>
                       <p class='content fw-bold mb-0'>
                           ${book["price"]}
                       </p>

                   </div>
                     <div class='item pb-1 w-100 '>
                       <div class='info head flex-nowrap'>
                           <h6 class='mb-0 fw-bold text-nowrap'><i class='fa-solid fa-tag me-1'></i>Subtotal </h6>
                       </div>
                       <p class='content subtotal fw-bold mb-0 ms-1'>
                           ${book["subtotal"]}
                       </p>

                   </div>
                      
                   
                   </div>
                          <div class='item m  '>
                       <div class='info head flex-nowrap'>
                           <h6 class='mb-0 fw-bold text-nowrap'> Quantity </h6>
                       </div>
                       <p class='content quantity fw-bold mb-0 ms-1'>
                           ${book["quantity"]}
                       </p>
                      
                      </div>

                   </div>
          </div> 
      `;
  }
}
