jQuery(".few-bas-slider").on("input change", (e)=> {
    const sliderPos = e.target.value
    jQuery(e.target).siblings('.few-bas-before').css('clip-path', `polygon(0% 0%, ${sliderPos}% 0%, ${sliderPos}% 100%, 0% 100%)`)
    jQuery(e.target).siblings('.few-bas-slider-button').css('left', `calc(${sliderPos}% - 20px)`)
});