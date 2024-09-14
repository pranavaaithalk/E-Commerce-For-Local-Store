window.addEventListener("load", function () {
    var is_interested_images = document.getElementsByClassName("is-interested-image");
    Array.from(is_interested_images).forEach(element => {
        element.addEventListener("click", function (event) {
            var XHR = new XMLHttpRequest();
            var item_id = event.target.getAttribute("item_id");

            // On success
            XHR.addEventListener("load", toggle_interested_success);

            // On error
            XHR.addEventListener("error", on_error);

            // Set up request
            XHR.open("GET", "api/toggle_interested.php?item_id=" + item_id);

            // Initiate the request
            XHR.send();

            document.getElementById("loading").style.display = 'block';
            event.preventDefault();
        });
    });

    var book = document.getElementById("book-form");
    book.addEventListener("submit", function (event) {
        var XHR = new XMLHttpRequest();

        // On success
        XHR.addEventListener("load", book_success);

        // On error
        XHR.addEventListener("error", on_error);

        // Set up request
        XHR.open("POST", "api/book_submit.php");

        XHR.send();

        document.getElementById("loading").style.display = 'block';
        event.preventDefault();
    });
});

var toggle_interested_success = function (event) {
    document.getElementById("loading").style.display = 'none';

    var response = JSON.parse(event.target.responseText);
    if (response.success) {
        var item_id = response.item_id;
        var is_interested_image = document.querySelectorAll(".item-id-" + item_id + " .is-interested-image")[0];
        
    if (response.is_interested) {
            is_interested_image.classList.add("fa-shopping-cart");
            is_interested_image.classList.remove("fa-plus");
        } else {
            location.reload();
            is_interested_image.classList.add("fa-plus");
            is_interested_image.classList.remove("fa-shopping-cart");
        }
    } else if (!response.success && !response.is_logged_in) {
        window.$("#login-modal").modal("show");
    }
};

var book_success = function (event) {
    document.getElementById("loading").style.display = 'none';

    var response = JSON.parse(event.target.responseText);
    if (response.success) {
        alert(response.message);
        location.reload();
    } else {
        alert(response.message);
    }
};
