
var flag = false;

function switch_theme() {
    if(flag) {
        document.documentElement.setAttribute('data-theme', 'light');
        flag = false;
    } else {
        document.documentElement.setAttribute('data-theme', 'dark');
        flag = true;
    }
}

function cards_slide_right(event) {
    console.log("test");
    const container = event.target.parentElement.getElementsByClassName('cards-container')[0];
    const card = container.getElementsByClassName('card-item');
    container.scrollLeft += card[0].offsetWidth;
}
function cards_slide_left(event) {
    const container = event.target.parentElement.getElementsByClassName('cards-container')[0];
    const card = container.getElementsByClassName('card-item');
    container.scrollLeft -= card[0].offsetWidth;
}




