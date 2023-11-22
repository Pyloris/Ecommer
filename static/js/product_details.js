// ----------------------------
const imgs = document.querySelectorAll('.img-select a');
const imgBtns = [...imgs];
let imgId = 1;

imgBtns.forEach((imgItem) => {
    imgItem.addEventListener('click', (event) => {
        event.preventDefault();
        imgId = imgItem.dataset.id;
        slideImage();
    });
});

function slideImage(){
    const displayWidth = document.querySelector('.img-showcase img:first-child').clientWidth;

    document.querySelector('.img-showcase').style.transform = `translateX(${- (imgId - 1) * displayWidth}px)`;
}

window.addEventListener('resize', slideImage);
// ------------------------------



// increment decrement code ------------------------------------
const dec = document.querySelector("#dec");
const inc = document.querySelector("#inc");
const quantityValue = document.querySelector("#quantity-value");

inc.addEventListener("click",()=>{
    quantityValue.innerHTML++;
});

dec.addEventListener("click",()=>{
    if(quantityValue.innerHTML>1){
        quantityValue.innerHTML--;
    }
});


// description details
const description = document.getElementById("description");
const details = document.getElementById("details");

description.addEventListener("click",()=>{
    document.querySelector(".details").classList.remove("detShow");
    document.querySelector(".description").classList.add("detShow");
});

details.addEventListener('click',()=>{
    document.querySelector(".description").classList.remove("detShow");
    document.querySelector(".details").classList.add("detShow");
});

