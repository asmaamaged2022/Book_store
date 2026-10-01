let RoleEle = document.querySelector(".part2[data-role]");
let role = RoleEle.dataset.role;
console.log(role);

document.addEventListener("DOMContentLoaded", function () {
  let type = window.location.search.replace("?", "").split("-")[0];
  targetBtn = document.querySelector(`#${type}-tab`);
  if (targetBtn != null) {
    targetBtn.click();
  }
});
let AddAuthorForm = document.querySelector("#AddAuthorForm"),
  authorTab = document.querySelector("#authors-tab-pane >.row");

AddAuthorForm.addEventListener("submit", function (e) {
  e.preventDefault();
  let formData = new FormData(this);
  fetch("Profile/addAuthor", {
    method: "POST",
    body: formData,
  })
    .then(async (response) => {
      let data = await response.json();
      if (!response.ok) {
        throw data;
      }
      return data;
    })
    //*fetch conceder all is success
    // .then(response => {
    //       if (!response.ok) {
    //             throw new Error("Request failed");
    //         }
    //     return response.json();
    // })
    .then((data) => {
      console.log(data);
      let htmlError = document.querySelectorAll(`#AddAuthorForm p[data-error-name]`),
        closeBtn = document.querySelector("#AddAuthorModal .close");
      htmlError.forEach((item) => {
        item.classList.add("d-none");
      });
      AddAuthorForm.reset();
      closeBtn.click();

      let AuthorTab = document.querySelector(`#AuthorTab`);

      AuthorTab.insertAdjacentHTML(
        "afterbegin",
        `
          <div class="col-xl-4 col-md-6 ">
          <div class='box mb-3'>
                <div class='item infoCard authorCard mainBg text-dark px-4 py-4 rounded-3'>

                    <div class='head text-center'>
                        <div class='image mb-3 mx-auto'>
                            <img
                                src='${imgPath("images", "author.png")}'
                                alt=''
                                class='img-fluid' />
                        </div>

                        <p class='name fw-bold'><i class='fa-solid fa-feather me-1'></i>${data.data["name"]}</p>
                    </div>

                    <div class='item mb-3  BioBox'>
                       <div class='info d-flex  align-items-center flex-nowrap'>
                           <h6 class='mb-0 headBio fw-bold text-nowrap'>About Author </h6>
                       </div>
                       <p class='content fw-bold mb-0 ms-1 bodyBio' title='${shortBio(data.data["bio"])}'>
                          ${shortBio(data.data["bio"])}
                            
                       </p>

                   </div> 
                   <button class='btn addBook mt-3 ' onclick='openAddBookPopup(${data.data["id"]},\"${data.data["name"]}\")' >Add New Book</button>

                </div>
            </div>
          </div>
          
      `,
      );
      authorTab.prepend(authorCard);
    })
    .catch((error) => {
      showErrors(error.data);
    });
});

let BookFilterForm = document.querySelector("#BooksFilterForm");

BookFilterForm.addEventListener("submit", function (e) {
  e.preventDefault();
  let formData = new FormData(this);
  fetch("Profile/FilterBooks", {
    method: "POST",
    body: formData,
  })
    .then(async (response) => {
      let data = await response.json();
      if (!response.ok) {
        throw data;
      }
      return data;
    })
    .then((respond) => {
      let books = respond.data.data,
        rowContent = document.querySelector("#books-tab-pane >.row"),
        ContentTab = document.querySelector("#books-tab-pane "),
        pagination = document.querySelector("#books-tab-pane nav[aria-label='Page navigation example']");
      if (pagination) {
        pagination.remove();
      }
      rowContent.innerHTML = "";
      if (books.length != 0) {
        books.forEach((book) => {
          rowContent.innerHTML += BookComponent(book, "filter");
        });
        ContentTab.insertAdjacentHTML("beforeend", preparePagination(respond.data));
      } else {
        rowContent.innerHTML = `
      <p class='alert alert-warning w-75 text-center mx-auto'>There are no Data</p>
      `;
      }
    })
    .catch((error) => {
      console.log(error);
    });
});

function preparePagination(data) {
  if (data["total"] != 0) {
    let prepareLi = "",
      pagesNumber = Math.ceil(data["total"] / 10),
      prevPageNumber = data["currentPage"] > 1 ? data["currentPage"] - 1 : 1,
      nextPageNumber = data["currentPage"] < pagesNumber ? data["currentPage"] + 1 : pagesNumber,
      isNextPageDisabled = data["currentPage"] == pagesNumber ? "disabled" : "",
      isPrevPageDisabled = data["currentPage"] == 1 ? "disabled" : "";
    for (let i = 1; i <= pagesNumber; i++) {
      let isActive = data["currentPage"] == i ? "active" : "";
      prepareLi += `
            <li class='page-item ${isActive}' ><button class='page-link' type="button"  onclick='changePage(${i})' data-page=${i}>${i}</button></li>
            `;
    }
    return `
  <nav aria-label='Page navigation example'>
      <ul class='pagination'>
          <li class='page-item ${isPrevPageDisabled}'><button type="button"  class='page-link' onclick='changePage(${prevPageNumber})' data-page=${prevPageNumber} >Previous</button></li>
         ${prepareLi}
          <li class='page-item ${isNextPageDisabled}'><button type="button"  class='page-link' onclick='changePage(${nextPageNumber})' data-page=${nextPageNumber}  >Next</button></li>
      </ul>
  </nav>
        `;
  }
  return "";
}

function changePage(pageNumber) {
  console.log("changePage", pageNumber);
  let BookFilterForm = document.querySelector("#BooksFilterForm"),
    paginationPage = document.querySelector("#BooksFilterForm #paginationPage");
  paginationPage.value = pageNumber;
  BookFilterForm.requestSubmit();
}
function openAddBookPopup(authorId, authorName) {
  let authorIdEle = document.querySelector("#AddBookModal #authorId option"),
    authorIdHiddenInput = document.querySelector("#AddBookModal #authorIdHidden");
  authorIdEle.value = authorId;
  authorIdHiddenInput.value = authorId;
  authorIdEle.textContent = authorName;
  openPopup("AddBookModal");
}

let AddBookForm = document.querySelector("#AddBookForm");

AddBookForm.addEventListener("submit", function (e) {
  e.preventDefault();
  let formData = new FormData(this);
  fetch("Profile/AddBook", {
    method: "POST",
    body: formData,
  })
    .then(async (response) => {
      let data = await response.json();
      if (!response.ok) {
        throw data;
      }
      return data;
    })
    .then((respond) => {
      let htmlError = document.querySelectorAll(`#AddBookForm p[data-error-name]`),
        closeBtn = document.querySelector("#AddBookModal .close"),
        rowContent = document.querySelector("#books-tab-pane >.row");

      htmlError.forEach((item) => {
        item.classList.add("d-none");
      });
      closeBtn.click();
      AddBookForm.reset();
      isError(["success", respond.message]);

      let imageFolder = respond.data["image"] == null ? "images" : "upload",
        image = respond.data["image"] == null ? "book.png" : respond.data["image"];

      rowContent.insertAdjacentHTML(
        "afterbegin",
        `
         <div class='col-xl-4 col-md-6 show ${role} ' data-book-id='${respond.data["id"]}'>
                        <div class='box mb-3'>
                            <div class='item infoCard bookCard mainBg text-dark px-4 py-4 rounded-3'>

                                <div class='head text-center'>
                                    <div class='image mb-3 mx-auto'>
                                        <img
                                            src='${imgPath(imageFolder, image)}'
                                            alt=''
                                            class='img-fluid rounded-circle' />
                                    </div>

                                    <p class='fw-bold name' title='${respond.data["title"]}'> <i class='fa-solid fa-book me-1' ></i>${respond.data["title"]}</p>
                                </div>

                                <div class='boxData'>
                                <div class='item mb-3  '>
                                    <div class='info d-flex  align-items-center flex-nowrap'>
                                        <h6 class='mb-0 fw-bold text-nowrap head w-100'><i class='fa-solid fa-feather me-1'></i>Author</h6>
                                    </div>
                                    <p class='content fw-bold mb-0 ms-1'>
                                        ${respond.data["author_name"]}
                                    </p>

                                </div>
                                <div class='item mb-3  '>
                                    <div class='info d-flex  align-items-center flex-nowrap'>
                                        <h6 class='mb-0 fw-bold text-nowrap head w-100'>Description </h6>
                                    </div>
                                    <p class='content fw-bold mb-0 ms-1 px-1 disc' title='${shortBio(respond.data["description"])}'>
                                    ${shortBio(respond.data["description"])}
                                    </p>

                                </div>
                               <div class='additionalInfo d-flex w-100'>
                                    <div class='item pb-1  w-100 borderline'>
                                        <div class='info  flex-nowrap head'>
                                            <h6 class='mb-0 fw-bold text-nowrap'> <i class='fa-solid fa-tag me-1'></i>Price </h6>
                                        </div>
                                        <p class='content fw-bold mb-0 '>
                                            ${respond.data["price"]}
                                        </p>

                                    </div>
                                    <div class='item pb-1 w-100'>
                                        <div class='info  flex-nowrap head'>
                                            <h6 class='mb-0 fw-bold text-nowrap'><i class='fa-brands fa-codepen me-1'></i>Stoke  </h6>
                                        </div>
                                        <p class='content stock fw-bold mb-0 ' id='BookStock-${respond.data["id"]}'>
                                           ${respond.data["stock"]}

                                        </p>
                                    </div>
                                </div>
                            </div>
                   </div>
               </div>
          </div> 
      `,
      );
    })
    .catch((error) => {
      showErrors(error.data);
    });
});
function banUser(userId, text) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: `Yes, ${text}!`,
  }).then((result) => {
    if (result.isConfirmed) {
      fetch("Profile/BanUser", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          userId: userId,
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
          let card = document.querySelector(`.item[data-user-id="${userId}"]`),
            badge = card.querySelector(".badgeBan"),
            banBtn = card.querySelector(".banBtn");

          if (respond.data[1] == 0) {
            badge.classList.remove("d-none");
            banBtn.classList.remove("btn-danger");
            banBtn.classList.add("IdentityButton");
            banBtn.textContent = "unBan";
            text = "Ban";
          } else {
            badge.classList.add("d-none");
            banBtn.classList.add("btn-danger");
            banBtn.classList.remove("IdentityButton");
            banBtn.textContent = "Ban";
            text = "UnBan";
          }

          Swal.fire({
            title: `${text}! `,
            text: `user has been ${text}.`,
            icon: "success",
          });
        })
        .catch((error) => {
          isError(["error", error.message]);
        });
    }
  });
}

function DoneOrder(orderId) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, Done Order!",
  }).then((result) => {
    if (result.isConfirmed) {
      fetch("Profile/DoneOrder", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          orderId: orderId,
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
          let trDone = document.querySelector(`#trOrder-id-${respond.data[0]["order_id"]}`);
          trInDoneTable = document.querySelector("#DoneTable");
          closeBtn = document.querySelector("#cancelReasonModel .close");
          trInDoneTable.insertAdjacentHTML(
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
            </tr>
      `,
          );
          trDone.remove();
        })
        .catch((error) => {
          console.log(error);
        });

      Swal.fire({
        title: "Done!",
        text: "this order Is Done",
        icon: "success",
      });
    }
  });
}

function cancelOrder(orderId) {
  openPopup("cancelReasonModel");
  let cancelReasonForm = document.querySelector("#cancelReasonForm");

  cancelReasonForm.addEventListener("submit", function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    formData.append("orderId", orderId);
    fetch("Profile/cancelOrder", {
      method: "POST",
      body: formData,
    })
      .then(async (response) => {
        let data = await response.json();
        if (!response.ok) {
          throw data;
        }
        return data;
      })
      .then((respond) => {
        let trDone = document.querySelector(`#trOrder-id-${respond.data[0]["order_id"]}`),
          trInCanceledTable = document.querySelector("#canceledTable");
        closeBtn = document.querySelector("#cancelReasonModel .close");
        trInCanceledTable.insertAdjacentHTML(
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
            </tr>
      `,
        );
        trDone.remove();
        closeBtn.click();
        cancelReasonForm.reset();
        isError(["success", respond.message]);
      })
      .catch((error) => {
        showErrors(error.data);
      });
  });
}
