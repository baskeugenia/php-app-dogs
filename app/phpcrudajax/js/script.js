// get pagination
function pagination(totalpages, currentpage) {
  var pagelist = "";
  if (totalpages > 1) {
    currentpage = parseInt(currentpage);
    pagelist += `<ul class="pagination justify-content-center">`;
    const prevClass = currentpage == 1 ? " disabled" : "";
    pagelist += `<li class="page-item${prevClass}"><a class="page-link" href="#" data-page="${
      currentpage - 1
    }">Previous</a></li>`;
    for (let p = 1; p <= totalpages; p++) {
      const activeClass = currentpage == p ? " active" : "";
      pagelist += `<li class="page-item${activeClass}"><a class="page-link" href="#" data-page="${p}">${p}</a></li>`;
    }
    const nextClass = currentpage == totalpages ? " disabled" : "";
    pagelist += `<li class="page-item${nextClass}"><a class="page-link" href="#" data-page="${
      currentpage + 1
    }">Next</a></li>`;
    pagelist += `</ul>`;
  }

  $("#pagination").html(pagelist);
}


// get dog row
function getdogrow(dog) {
  var dogRow = "";
  if (dog) {
    dog_can_hunt = (dog.can_hunt == 1) ? "yes" : "no";
    dogRow = `<tr>
          <td></td>
          <td class="align-middle">${dog.name}</td>
          <td class="align-middle">${dog.type}</td>
          <td class="align-middle">${dog.voice}</td>
          <td class="align-middle">${dog_can_hunt}</td>
          <td class="align-middle">
            <a href="#" class="btn btn-success mr-3 profile" data-toggle="modal" data-target="#dogViewModal"
              title="Profile" data-id="${dog.id}"><i class="fa fa-address-card-o" aria-hidden="true"></i></a>
            <a href="#" class="btn btn-warning mr-3 editdog" data-toggle="modal" data-target="#dogModal"
              title="Edit" data-id="${dog.id}"><i class="fa fa-pencil-square-o fa-lg"></i></a>
            <a href="#" class="btn btn-danger deletedog" data-dogid="14" title="Delete" data-id="${dog.id}"><i
                class="fa fa-trash-o fa-lg"></i></a>
          </td>
        </tr>`;
  }
  return dogRow;
}


// get dogs list
function getdogs() {
  var pageno = $("#currentpage").val();
  $.ajax({
    url: "/phpcrudajax/ajax.php",
    type: "GET",
    dataType: "json",
    data: { page: pageno, action: "getdogs" },
    beforeSend: function () {
      $("#overlay").fadeIn();
    },
    success: function (rows) {
      console.log(rows);
      if (rows.dogs) {
        var dogslist = "";
        $.each(rows.dogs, function (index, dog) {
          dogslist += getdogrow(dog);
        });
        $("#dogstable tbody").html(dogslist);
        let totalDogs = rows.count;
        let totalpages = Math.ceil(parseInt(totalDogs) / 4);
        const currentpage = $("#currentpage").val();
        pagination(totalpages, currentpage);
        $("#overlay").fadeOut();
      }
    },
    error: function () {
      console.log("something went wrong");
    },
  });
}


$(document).ready(function () {
  // add/edit dog
  $(document).on("submit", "#addform", function (event) {
    event.preventDefault();
    var alertmsg =
      $("#dogid").val().length > 0
        ? "Dog has been updated Successfully!"
        : "New Dog has been added Successfully!";
    $.ajax({
      url: "/phpcrudajax/ajax.php",
      type: "POST",
      dataType: "json",
      data: new FormData(this),
      processData: false,
      contentType: false,
      beforeSend: function () {
        $("#overlay").fadeIn();
      },
      success: function (response) {
        console.log(response);
        if (response) {
          $("#dogModal").modal("hide");
          $("#addform")[0].reset();
          $(".message").html(alertmsg).fadeIn().delay(3000).fadeOut();
          getdogs();
          $("#overlay").fadeOut();
        }
      },
      error: function () {
        console.log("Oops! Something went wrong!");
      },
    });
  });


  // pagination
  $(document).on("click", "ul.pagination li a", function (e) {
    e.preventDefault();
    var $this = $(this);
    const pagenum = $this.data("page");
    $("#currentpage").val(pagenum);
    getdogs();
    $this.parent().siblings().removeClass("active");
    $this.parent().addClass("active");
  });
  // form reset on new button
  $("#addnewbtn").on("click", function () {
    $("#addform")[0].reset();
    $("#dogid").val("");
  });


  //  get dog
  $(document).on("click", "a.editdog", function () {
    console.log('EDIT DOG');
    var pid = $(this).data("id");

    $.ajax({
      url: "/phpcrudajax/ajax.php",
      type: "GET",
      dataType: "json",
      data: { id: pid, action: "getdog" },
      beforeSend: function () {
        $("#overlay").fadeIn();
      },
      success: function (dog) {
        if (dog) {
          $("#dogname").val(dog.name);
          $("#type").val(dog.type_id);
          $("#voice").val(dog.voice);
          $dch = dog.can_hunt == 0 ? false : true;
          $("#canhunt").prop("checked", $dch);
          $("#dogid").val(dog.id);
        }
        $("#overlay").fadeOut();
      },
      error: function () {
        console.log("something went wrong");
      },
    });
  });


  // delete dog
  $(document).on("click", "a.deletedog", function (e) {
    e.preventDefault();
    var pid = $(this).data("id");
    if (confirm("Are you sure want to delete this?")) {
      $.ajax({
        url: "/phpcrudajax/ajax.php",
        type: "GET",
        dataType: "json",
        data: { id: pid, action: "deletedog" },
        beforeSend: function () {
          $("#overlay").fadeIn();
        },
        success: function (res) {
          if (res.deleted == 1) {
            $(".message")
              .html("Dog has been deleted successfully!")
              .fadeIn()
              .delay(3000)
              .fadeOut();
            getdogs();
            $("#overlay").fadeOut();
          }
        },
        error: function () {
          console.log("something went wrong");
        },
      });
    }
  });


  $(document).on("click", "a.profile", function () {
    var pid = $(this).data("id");
    $.ajax({
      url: "/phpcrudajax/ajax.php",
      type: "GET",
      dataType: "json",
      data: { id: pid, action: "getdog" },
      success: function (dog) {
        if (dog) {
          dog_can_hunt = (dog.can_hunt == 1) ? "yes" : "no";
          const profile = `<div class="row">
                <div class="col-sm-6 col-md-8">
                  <h4 class="text-primary">${dog.name}</h4>
                  <p class="text-secondary">
                    Type: ${dog.type}
                    <br />
                    Voice: ${dog.voice}
                    <br />
                    Can hunt: ${dog_can_hunt}
                  </p>
                </div>
              </div>`;
          $("#profile").html(profile);
        }
      },
      error: function () {
        console.log("something went wrong");
      },
    });
  });


  // searching
  $("#searchinput").on("keyup", function () {
    const searchText = $(this).val();
    if (searchText.length > 0) {
      $.ajax({
        url: "/phpcrudajax/ajax.php",
        type: "GET",
        dataType: "json",
        data: { searchQuery: searchText, action: "search" },
        success: function (dogs) {
          if (dogs) {
            var dogslist = "";
            $.each(dogs, function (index, dog) {
              dogslist += getdogrow(dog);
            });
            $("#dogstable tbody").html(dogslist);
            $("#pagination").hide();
          }
        },
        error: function () {
          console.log("something went wrong");
        },
      });
    } else {
      getdogs();
      $("#pagination").show();
    }
  });

  getdogs();
});
