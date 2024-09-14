window.addEventListener("load", function () {
    const search = window.location.search;
    const params = new URLSearchParams(search);
    const item_id = params.get('item_id');

    var is_interested_image = document.getElementsByClassName("is-interested-image")[0];
    is_interested_image.addEventListener("click", function (event) {
        var XHR = new XMLHttpRequest();

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

    var wanted = document.getElementsByClassName("booknow")[0];
    wanted.addEventListener("click", function (event) {
        var XHR = new XMLHttpRequest();

        // On success
        XHR.addEventListener("load", toggle_wanted_success);

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

var toggle_interested_success = function (event) {
    document.getElementById("loading").style.display = 'none';

    var response = JSON.parse(event.target.responseText);
    if (response.success) {
        var is_interested_image = document.getElementsByClassName("is-interested-image")[0];

        if (response.is_interested) {
            is_interested_image.classList.add("fa-shopping-cart");
            is_interested_image.classList.remove("fa-plus");
        } else {
            is_interested_image.classList.add("fa-plus");
            is_interested_image.classList.remove("fa-shopping-cart");
        }
    } else if (!response.success && !response.is_logged_in) {
        window.$("#login-modal").modal("show");
    }
};

var toggle_wanted_success = function (event) {
    document.getElementById("loading").style.display = 'none';

    var response = JSON.parse(event.target.responseText);
    if (response.success) {
        alert("Item Added To Cart. Check Out!");
        location.reload();
    } else {
        alert(response.message);
    }
};

