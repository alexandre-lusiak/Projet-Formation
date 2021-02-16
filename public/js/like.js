///////////////////////////////////
////scripts js pour les like(ajax)

function onClickLike(event) {
    
    // stay on the same page by canceling the default operation
    
        event.preventDefault(); 
        
    // we get the url of the link (this = the element that triggers the event(a)
        const url = this.href;
        const spanCount= this.querySelector('span.likes-js');
        const fontIcone=this.querySelector('i');
        
    // have used axios for managing promises (then)
        axios.get(url).then(function(response){
            
    // we retrieve the data data (console.log (response)) in json format   
            const likes = response.data.nb_likes;
            
    // we get the number of likes    
            spanCount.textContent = likes;
            
    // logic for the management of icons font awsom by acting on the class  
            if (fontIcone.classList.contains('fas')){
                fontIcone.classList.replace('fas', 'far');
            }
            else{
                fontIcone.classList.replace('far','fas');
            }
        }).catch(function(error) {
            if(error.response.status === 403) {
                alert('connecté vous pour pouvoir liker');
            }
        });
    }
    // we get all the a that have the js-like class we get an array and we loop on each link(a)//
    document.querySelectorAll('a.js-like').forEach(function(link) {
        link.addEventListener('click', onClickLike);
    });