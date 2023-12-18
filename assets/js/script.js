function showLoader() {
    $("#loader_content").removeClass("hidden");
}

function hideLoader() {
    $("#loader_content").addClass("hidden");
}

function debounce(func, timeout = 300) {
    let timer;
    return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => {
            func.apply(this, args);
        }, timeout);
    };
}

const removeFromCart = (id) => {
    let items = sessionStorage.getItem("conquerorItems");
    items = JSON.parse(items);
    delete items[id];
    sessionStorage.setItem("conquerorItems", JSON.stringify(items));
};

const changeItemCart = (id, value) => {
    let items = sessionStorage.getItem("conquerorItems");
    items = JSON.parse(items);
    items[id]["qty"] = value * 1;
    sessionStorage.setItem("conquerorItems", JSON.stringify(items));
};

const checkoutHtml = () => {
    if (sessionStorage.getItem("conquerorItems")) {
        let items = sessionStorage.getItem("conquerorItems");

        showLoader();
        $.post(
            {
                url: theConquerorJSData.ajax_url + "?action=getCheckoutData",
            },
            {
                cartData: items,
            }
        )
            .done(function (data) {
                if (data["error"] === true) {
                    console.log(data.message);
                } else {
                    $("#checkout_list").html(data.data);
                }
                hideLoader();
            })
            .fail(function (data) {
                console.log(data["message"]);
                hideLoader();
            });
    } else {
        $("#checkout_list").html("No items added to cart");
    }
};

const cartHtml = () => {
    let items = sessionStorage.getItem("conquerorItems");
    if (null === items) {
        $("#main_cart_details_data").html("No items added to cart");
        $("#main_total_text").hide();
    } else {
        showLoader();
        $.post(
            {
                url: theConquerorJSData.ajax_url + "?action=getCartData",
            },
            {
                cartData: items,
            }
        )
            .done(function (data) {
                if (data["error"] === true) {
                    console.log(data.message);
                } else {
                    $("#main_cart_details_data").html(data.data.html);
                    if (data.data.total > 0) {
                        $("#main_total").html(data.data.total);
                        $("#main_total_text").show();
                    } else {
                        $("#main_total_text").hide();
                    }
                }
                hideLoader();
            })
            .fail(function (data) {
                console.log(data["message"]);
                hideLoader();
            });
    }
};

jQuery(document).ready(function ($) {
    let windowWidth = window.innerWidth;

    // Checkout list
    if ($("#checkout_list").length) {
        checkoutHtml();
    }

    $("body").on(
        "change",
        "#checkout_list td.qty input",
        debounce((e) => {
            e.stopPropagation();
            e.stopImmediatePropagation();

            let element = $(e.target);
            let value = element.val();
            let id = element.closest("tr").attr("attr-id");
            if (value * 1 === 0) {
                $(e.target)
                    .closest("tr")
                    .find("td.delete svg")
                    .trigger("click");
            } else {
                changeItemCart(id, value);
            }
            checkoutHtml();
        })
    );

    $("body").on("click", "#checkout_list td.delete svg", (e) => {
        e.stopPropagation();
        e.stopImmediatePropagation();

        let element = $(e.target);
        let id = element.closest("tr").attr("attr-id");
        removeFromCart(id);
        $("tr[attr-id='" + id + "']").remove();
        checkoutHtml();
    });

    $("body").on("click", "#to_checkout", (e) => {
        e.stopPropagation();
        e.stopImmediatePropagation();
        let element = $(e.target);

        if (!element.hasClass("disabled")) {
            element.addClass("disabled");
            alert("To checkout");
        }
    });

    // Add to cart from list
    $("body").on("click", ".add_to_cart", (e) => {
        let idElement = $(e.target).closest(".challenge_data");

        if (idElement.length > 0) {
            let id = idElement.attr("attr-id");

            if (!sessionStorage.getItem("conquerorItems")) {
                sessionStorage.setItem("conquerorItems", "{}");
            }

            let items = JSON.parse(sessionStorage.getItem("conquerorItems"));

            if (items[id] === undefined) {
                items[id] = { qty: 1 };
            } else {
                items[id]["qty"]++;
            }

            sessionStorage.setItem("conquerorItems", JSON.stringify(items));
            $("#main_cart_details").hide();
            $("#main_cart_icon").trigger("click");
        }
    });

    // Main menu cart icon
    $("body").on("click", "#main_cart_icon", (e) => {
        e.stopPropagation();
        e.stopImmediatePropagation();

        if (!$("#main_cart_details").is(":visible")) {
            cartHtml();
        }

        $("#main_cart_details").toggle();
    });

    // Cart popup
    $("body").on(
        "change",
        "#main_cart_details .main_cart_input",
        debounce((e) => {
            e.stopPropagation();
            e.stopImmediatePropagation();

            let value = e.target.value;
            let id = $(e.target).closest("li").attr("attr-id");
            if (value * 1 === 0) {
                $(e.target)
                    .closest("li")
                    .find(".main_cart_delete")
                    .trigger("click");
            } else {
                changeItemCart(id, value);
            }
            cartHtml();
        })
    );

    $("body").on("click", "#main_cart_details .main_cart_delete", (e) => {
        e.stopPropagation();
        e.stopImmediatePropagation();
        let id = $(e.target).closest("li").attr("attr-id");
        removeFromCart(id);
        $("#main_cart_details_data li[attr-id='" + id + "']").remove();
        cartHtml();
    });

    $("body").on("click", "#go_to_summary", (e) => {
        e.stopPropagation();
        e.stopImmediatePropagation();

        window.location.href = theConquerorJSData.summary_url;
    });

    // Order by
    $("body").on("change", ".sort_select", (e) => {
        e.stopPropagation();
        e.stopImmediatePropagation();
        let value = e.target.value;

        showLoader();
        $.post(
            {
                url: theConquerorJSData.ajax_url + "?action=getChallengesSort",
            },
            {
                orderBy: value,
            }
        )
            .done(function (data) {
                if (data["error"] === true) {
                    $("#challenges_list").html(data.message);
                } else {
                    $("#challenges_list").html(data.data);
                }
                hideLoader();
            })
            .fail(function (data) {
                console.log(data["message"]);
                hideLoader();
            });
    });

    $(window).on("click", function (e) {
        // Little bit messy, but for now is ok
        let element = $(e.target);
        if (
            element.attr("id") ||
            element.closest("#main_cart_details").length === 0
        ) {
            $("#main_cart_details").hide();
        }
    });
});
