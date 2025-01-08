<!DOCTYPE html>
<html lang="en">
<?php include 'view/modulos/head.php';?>
<body>
<?php include 'view/modulos/navegador2.php';?>
    <div id="hero" class="hero overlay subpage-hero contact-hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Contact</h1>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Contact</li>
                </ol>
            </div><!-- /.hero-text -->
        </div><!-- /.hero-content -->
    </div><!-- /.hero -->

    <main id="main" class="site-main">

        <section class="site-section subpage-site-section section-contact-us">

            <div class="container">
                <div class="row">
                    <div class="col-sm-7">
                        <h2>Send a message</h2>
                        <form>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                      <label for="name">Name:</label>
                                      <input type="text" class="form-control" id="name">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                      <label for="email">E-mail:</label>
                                      <input type="email" class="form-control" id="email">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                              <label for="message">Subject:</label>
                              <input class="form-control" id="subject"></input>
                            </div>
                            <div class="form-group">
                              <label for="message">Message:</label>
                              <textarea class="form-control form-control-comment" id="message"></textarea>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-green">Contact us</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-5">
                        <div class="contact-info">
                            <h2>Contact information</h2>
                            <div class="row">
                                <div class="col-sm-12">
                                    <h3>Address</h3>
                                    <ul class="list-unstyled">
                                        <li>Sydney, Australia</li>
                                        <li>100 Mainstreet Center</li>
                                    </ul>
                                    <h3>E-mail</h3>
                                    <a href="mailto:pixelperfectmk@gmail.com" target="_blank">pixelperfectmk@gmail.com</a>
                                    <h3>Phone</h3>
                                    <a href="tel:2083339296" target="_blank">(208) 333 9296</a>
                                    <h3>Fax</h3>
                                    <p>(208) 333 9296</p>
                                </div>
                            </div>
                        </div><!-- /.contact-info -->
                    </div>
                </div>
            </div>
            
        </section><!-- /.section-contact-us -->

        <section id="map" class="section-map"></section><!-- /.section-map -->

    </main><!-- /#main -->

</body>
<?php include 'view/modulos/footer.php';?>
</html>