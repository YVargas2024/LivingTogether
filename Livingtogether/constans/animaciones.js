    // add hovered class to selected list item
    let list = document.querySelectorAll(".navigationn li");
    let botones=document.querySelectorAll(".Opcionn button")

    function activeLink(){
        list.forEach((item)=>{
            item.classList.remove("hovered");
        });
        this.classList.add("hovered");
        botones.forEach((item)=>{
            item.classList.remove("hovered");
        });
        this.classList.add("hovered");
    }

    list.forEach((item) => item.addEventListener("mouseover", activeLink));
    botones.forEach((item) => item.addEventListener("mouseover", activeLink));


    // Menu Toggle

    let toggle = document.querySelector(".togglee");
    let navigation = document.querySelector(".navigationn");
    let main = document.querySelector(".mainn");

    toggle.onclick = function(){
        navigation.classList.toggle("active");
        main.classList.toggle("active");
    };