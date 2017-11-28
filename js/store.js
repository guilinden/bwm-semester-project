window.onload = function(){
    var increase = document.getElementById("increase");
    var decrease = document.getElementById("decrease");
    var value = 1;
    var newPrice;

    increase.addEventListener("click", increaseValue);
    decrease.addEventListener("click", decreaseValue);

    function increaseValue(){
        document.getElementById("value").value = value+1;
        value++;
        newPrice = value*300;
        document.getElementById("price").innerHTML = "$" + newPrice;
    }

    function decreaseValue(){
        document.getElementById("value").value = value-1;
        value--;
        newPrice = value*300;
        document.getElementById("price").innerHTML = "$" + newPrice;   
    }

    var buy = document.getElementById("buy");
    buy.addEventListener("click",sendOrder);

    function sendOrder(){
        window.location = "checkout.php?value=" + newPrice;
    }
};