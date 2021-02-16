'use strict'
    ////////////////////////////
    ///Script JS word change ///
    ////////////////////////////

window.addEventListener('load', function () { 
    
    let package_word= ['CARE','REPAIRE','RE-WEAR'];
    let word = document.getElementById('word');
    let intervalTime= window.setInterval(randomText, 3000, word);
    
    function randomText(word) {
        let random_word =Math.floor(Math.random() * package_word.length);
        let word_emerge = package_word[random_word];
        return word.innerHTML = word_emerge;
    }
});