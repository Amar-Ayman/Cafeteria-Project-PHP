<?php require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/nav.php') ?>

<div class="banner">
    <img src="/images/banner.png" alt="">
    <div class="banner-buttons">
            <a href="/user/products">Order Now</a>
            <a href="#reserve">Reserve Table</a>
    </div>
</div>
    <div class="about">
        <h1>About Us</h1>
        <div class="container">
            <div class="text">
                <p>
                    Welcome to SERENO CAFÉ, where elegance meets the art of coffee. Located inside the heart of a luxurious hotel, our café offers a unique experience combining premium coffee, refined atmosphere, and exceptional hospitality.
                    At SERENO CAFÉ, we believe every cup tells a story. Our carefully selected ingredients, handcrafted beverages, and elegant desserts are prepared to create unforgettable moments for our guests.
                    Enjoy your time in our spacious and relaxing lounge, surrounded by warm lighting, sophisticated design, and a peaceful atmosphere perfect for meetings, conversations, or simply enjoying your favorite drink.
                    <span>Opening Hours:</span>
                    Daily: 7:00 AM – 2:00 AM
                    <span>Location:</span> 
                    Located inside the Luxury Hotel, offering a premium café experience in a comfortable and exclusive environment.
                    SERENO CAFÉ — More than a café, it's an experience. ☕✨
                </p>            
            </div>
            <div class="image">
                <img src="/images/cafe.png" alt="">
            </div>
        </div>
    </div>
    <div class="menu">
        <h2>Our Menu</h2>
        <div class="container">
            <div class="image">
               <a href="#"> <img src="/images/menu.jpg" alt=""></a>
                <button>view all→ </button>
             </div>
            <div class="text">
                <p>
                    Discover the taste of SERENO CAFÉ, where every item is carefully crafted to bring you a premium café experience. From rich handcrafted coffee and refreshing beverages to our delicious desserts, every detail is made to match the elegance of our atmosphere.
                    Our menu combines quality ingredients, unique flavors, and beautiful presentation to create moments worth remembering.
                    Whether you are looking for a relaxing coffee break, a sweet treat, or a special gathering, SERENO CAFÉ offers the perfect choice for every occasion
                </p>
            </div>
        </div>
    </div>
    <div class="item">
        <div class="card">
        <span class="badge best">Best Seller</span>
        <img src="/images/Pistachio Dream Cheesecake.png" alt="">
        <h2 class="name">Pistachio Dream Cheesecake</h2>
        <h2 class="price">170 EGY</h2>
        <div class="buttons">
            <button class="order" data-id="1">
                 Order Now
            </button>
            <button>add to cart+</button>
        </div>
    </div>

    <div class="card">
        <span class="badge new">New</span>
        <img src="/images/Salted Caramel Cold Brew.png" alt="">
        <h2 class="name">Salted Caramel Cold Brew</h2>
        <h2 class="price">120 EGY</h2>
        <div class="buttons">
            <button class="order" data-id="2">
                Order Now
            </button>
            <button>add to cart+</button>
        </div>
    </div>

    <div class="card">
        <span class="badge offer"> OFFER</span>
        <img src="/images/White Chocolate Mocha.png" alt="">
        <h2 class="name">White Chocolate Mocha</h2>
        <h2 class="price">120 EGY</h2>
        <div class="buttons">
            <button class="order" data-id="3">
                Order Now
            </button>
            <button>add to cart+</button>
        </div>
    </div>
</div>
<div class="reserve-section" id="reserve">
    <p class="first">Reservations</p>
    <h2>Reserve Your Table</h2>
    <p class="sec">Book in advance for the best experience. Private dining available upon request.</p>

    <?php if (Core\Auth::check()): ?>
        <form>
           <div class="inputs">
                <div class="field">
                    <input type="text" id="name" placeholder=" ">
                    <label for="name">
                        <span>Y</span><span>o</span><span>u</span><span>r</span>
                        <span> </span>
                        <span>N</span><span>a</span><span>m</span><span>e</span>
                    </label>
                </div>
                <div class="field">
                    <input type="text" id="time" placeholder=" ">
                    <label for="time">
                        <span>D</span><span>a</span><span>t</span><span>e</span>
                        <span> </span>
                        <span>&</span>
                        <span> </span>
                        <span>T</span><span>i</span><span>m</span><span>e</span>
                    </label>
                </div>
                <div class="field">
                    <input type="number" id="guests" placeholder=" " min="1">
                    <label for="guests">
                        <span>G</span><span>u</span><span>e</span><span>s</span><span>t</span><span>s</span>
                    </label>
                </div>
                <div class="submit-wrap">
                    <input type="submit" class="submit" value="Book Now">
                </div>
            </div>
        </form>
    <?php else: ?>
        <div class="login-prompt">
            <p>Please <a href="/login">login</a> to reserve a table.</p>
        </div>
    <?php endif; ?>
</div>

    <link rel="stylesheet" href="/css/home.css">
   <script>

document.querySelectorAll(".order").forEach(button => {

    button.addEventListener("click", function(){

        let card = this.closest(".card");

        let product = {

            id: this.dataset.id,

            image: card.querySelector("img").src,

            name: card.querySelector(".name").innerText,

            price: card.querySelector(".price").innerText

        };


        localStorage.setItem(
            "orderProduct",
            JSON.stringify(product)
        );


        window.location.href = "/order";

    });

});

</script>
<?php require base_path('views/partials/footer.php') ?>


