var currentSlide = 0;
var slides = document.querySelectorAll('.slide');
var totalSlides = slides.length;

function showSlide(index) {
  if (index < 0) {
    currentSlide = totalSlides - 1;
  } else if (index >= totalSlides) {
    currentSlide = 0;
  } else {
    currentSlide = index;
  }

  document.querySelector('.slides').style.transform = 'translateX(' + (-currentSlide * 100) + '%)';
  updateIndicators();
}

function nextSlide() {
  showSlide(currentSlide + 1);
}

function prevSlide() {
  showSlide(currentSlide - 1);
}

function createIndicators() {
  var indicatorsContainer = document.querySelector('.indicators');
  for (var i = 0; i < totalSlides; i++) {
    var indicator = document.createElement('div');
    indicator.classList.add('indicator');
    indicator.setAttribute('onclick', 'showSlide(' + i + ')');
    indicatorsContainer.appendChild(indicator);
  }
  updateIndicators();
}

function updateIndicators() {
  var indicators = document.querySelectorAll('.indicator');
  indicators.forEach(function (indicator, index) {
    if (index === currentSlide) {
      indicator.classList.add('active');
    } else {
      indicator.classList.remove('active');
    }
  });
}

function autoSlide() {
  nextSlide();
}

createIndicators();
setInterval(autoSlide, 5000);



// feature card hover effect
const featureCards = document.querySelectorAll(".feature-card");

featureCards.forEach(card =>{
    card.addEventListener("mouseover",()=>{
        card.querySelector(".hover").classList.add("hover-show");
    });
});

featureCards.forEach(card =>{
    card.addEventListener("mouseout",()=>{
        card.querySelector(".hover").classList.remove("hover-show");
    });
});