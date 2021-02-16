'use strict';
        //////////////////////////////////
        ////script js pour carousele/////
        /////////////////////////////////

document.addEventListener('DOMContentLoaded', () => {
    
    //fetching slides via their class//
    /*********************************/
    let slides = document.getElementsByClassName('carousel_item');
    //length of array slides// 
    /************************/
    const totalSlides= slides.length;
    let slidePosition =0;
    
    //button retrieval from their id //
    /*********************************/
    let btnNext =  document.getElementById('carousel_btn-next'); 
    let btnPrev =  document.getElementById('carousel_btn-prev');
    
    //change of class according to the slides array retrieved previously//
    /********************************************************************/
    function updateSlidePosition() {
        for (let slide of slides) {
            slide.classList.remove('carousel_item-visible'); 
            slide.classList.add('carousel_item-visible-hidden');
        }
        
        slides[slidePosition].classList.add('carousel_item-visible');
    }
    
    //////////////////////////////////
    // logic of slide position change/
    /////////////////////////////////
    
    function moveToNextSlide() {  
        updateSlidePosition();
        if(slidePosition == totalSlides - 1) {
            slidePosition = 0;
        }
        else {
            slidePosition++;
        }
    }    
    
    function moveToPrevSlide() {
        updateSlidePosition();
        if(slidePosition == 0) {
            slidePosition = totalSlides - 1;
        }
        else {
            slidePosition--;
        }
    }      
    
       //////////////////////////////////////////////////////////
       // activation of slides according to the clicke event   //
       //////////////////////////////////////////////////////////
     btnNext.addEventListener('click', () => {
        moveToNextSlide();
    });
    
    
    btnPrev.addEventListener('click', () => {
         moveToPrevSlide();
    });
});