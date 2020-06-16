    
    $(".card").on("click",function() {
  let me = this;
  (this).classList.toggle("large");
  let cards = $(".card");
  cards.each(function(index, element) {
    let card = element;
    if(card !== me)
    {
      card.classList.remove("large");
    }
  });
});