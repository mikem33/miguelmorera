var canvas = document.querySelector( 'canvas' );

function canvasResize() {
    canvasWidth = window.innerWidth;
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    console.log( 'resize' );
    return canvasWidth;
}

canvasResize();
window.addEventListener( 'resize', canvasResize, false );

var ctx = canvas.getContext( '2d' );

// Circle Object creator
function Circle( x, y, dx, dy, radius) {
    // height and width
    this.x = x;
    this.y = y;
    // changes position of cicrle
    this.dx = dx;
    this.dy = dy;
    // radius of circle
    this.radius = radius;

    // draw method called from end of update method
    this.draw = function() {
        ctx.beginPath();
        ctx.arc( this.x, this.y, this.radius, 0, Math.PI * 2, false );
        ctx.strokeStyle = 'rgba(255,255,255,.31)';
        ctx.lineWidth = 2;
        ctx.stroke();
    };

    // update method called to change positon of circle and change directions if hits the edge
    this.update = function() {
        // changes direction if hits the edge
        if ( this.x + this.radius > innerWidth || this.x - this.radius < 0 ) {
            this.dx = -this.dx;
        }

        if ( this.y + this.radius > innerHeight || this.y - this.radius < 0 ) {
            this.dy = -this.dy;
        }

        // updates the location of the circle
        this.x += this.dx;
        this.y += this.dy;
        // draws circle after updated postion
        this.draw();
    };
}



var circleArray = [];
var circles = ( window.innerWidth - window.innerHeight ) / 12;
console.log(circles);
if ( circles < 0 ) {
    circles = 20;
} else if ( circles > 40 ) {
    circles = 40;
}

// generates circles
for ( var i = 0; i < circles; i++ ) {
    var radius = 5 * ( i / 2 );
    var x = Math.random() * ( innerWidth - radius * 2 ) + radius;
    var y = Math.random() * ( innerHeight - radius * 2 ) + radius;
    var dx = ( Math.random() - 0.5 );
    var dy = ( Math.random() - 0.5 );
    
    circleArray.push( new Circle( x, y, dx, dy, radius ) );
}

// animation loop
function animate() {
    // calls animate function
    requestAnimationFrame( animate );
    // clears canvas after each move
    ctx.clearRect( 0, 0, innerWidth, innerHeight );
    
    // calls each cicrle every frame to update
    for ( var j= 0; j< circleArray.length; j++ ) {
        circleArray[j].update();
    }
}

animate();