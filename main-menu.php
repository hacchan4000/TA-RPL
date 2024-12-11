<?php
    session_start();
    if (isset($_SESSION['Username'])&& isset($_SESSION['Nim'])) {
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Menu</title>

    <link rel="stylesheet" href="styles/pages/main-menu.css">
    <link rel="stylesheet" href="styles/pages/main-menu-timeline.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" >

<!-- Optional theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">


</head>

<body>
    <header> 
        <nav class="navigasi-mm">
            <a href="pengumpulan.html">PENGUMPULAN TA</a>
            <a href="status.html">STATUS TA</a>
            <a href="notif.php">NOTIFICATION</a>
            <a href="#">CONTACTS</a>
            
        </nav>
        <a class="profil" href="profil.html"><ion-icon name="person-circle-outline"></ion-icon></a>

       
    </header>


    
    <div class="utama"> 
        
       
        <div class="image-container">
            <h1 class="intro">INTRODUCING</h1>
            <video class="monita" src="gambar/background/monita-vid.mp4" alt="" autoplay muted loop></video>
            <h1 class="judul">A REVOLUTIONARY WAY TO COMPLETE A THESIS</h1>
            <h1 class="todo"> Things TO DO</h1>
            <h2 class="quotes">"Your time is limited, so dont waste it living someone else's"</h2>
            <h2 class="quotes">- Steve Jobs</h2>

        </div>

        <br><br><br>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-timeline">
                        <div class="timeline">
                            <a href="#" class="timeline-content">
                                <span class="timeline-year">PROGRESS AWAL</span>
                                <div class="timeline-icon">
                                    <i class="fa fa-rocket"></i>
                                </div>
                                <div class="content">
                                    <h3 class="title">STEP 1</h3>
                                    <p class="description">
                                        Silahkan upload semua berkas verifikasi diri kedalam link berikut. Setelah berkas telah di verifikasi oleh admin, anda dapat mengkases layanan MONITA lebih lanjut.
                                    </p>
                                </div>
                            </a>
                        </div>
                        <div class="timeline">
                            <a href="#" class="timeline-content">
                                <span class="timeline-year">BAB I</span>
                                <div class="timeline-icon">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="content">
                                    <h3 class="title">STEP 2</h3>
                                    <p class="description">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias animi dolor in, maiores natus ipsum dolor sit amet, consectetur adipisicing elit. Alias animi dolor in, maiores natus.
                                    </p>
                                </div>
                            </a>
                        </div>
                        
                        
                        <div class="timeline">
                            <a href="#" class="timeline-content">
                                <span class="timeline-year">BAB II</span>
                                <div class="timeline-icon">
                                    <i class="fa fa-cog"></i>
                                </div>
                                <div class="content">
                                    <h3 class="title">step 3</h3>
                                    <p class="description">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias animi dolor in, maiores natus ipsum dolor sit amet, consectetur adipisicing elit. Alias animi dolor in, maiores natus.
                                    </p>
                                </div>
                            </a>
                        </div>
                        <div class="timeline">
                            <a href="#" class="timeline-content">
                                <span class="timeline-year">BAB III</span>
                                <div class="timeline-icon">
                                    <i class="fa fa-heart"></i>
                                </div>
                                <div class="content">
                                    <h3 class="title">STEP 4</h3>
                                    <p class="description">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias animi dolor in, maiores natus ipsum dolor sit amet, consectetur adipisicing elit. Alias animi dolor in, maiores natus.
                                    </p>
                                </div>
                            </a>
                        </div>
                        
                        
                        <div class="timeline">
                            <a href="#" class="timeline-content">
                                <span class="timeline-year">BAB IV</span>
                                <div class="timeline-icon">
                                    <i class="fa fa-web"></i>
                                </div>
                                <div class="content">
                                    <h3 class="title">STEP 5</h3>
                                    <p class="description">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias animi dolor in, maiores natus ipsum dolor sit amet, consectetur adipisicing elit. Alias animi dolor in, maiores natus.
                                    </p>
                                </div>
                            </a>
                        </div>
                        <div class="timeline">
                            <a href="#" class="timeline-content">
                                <span class="timeline-year">BAB V</span>
                                <div class="timeline-icon">
                                    <i class="fa fa-apple"></i>
                                </div>
                                <div class="content">
                                    <h3 class="title">STEP 6</h3>
                                    <p class="description">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias animi dolor in, maiores natus ipsum dolor sit amet, consectetur adipisicing elit. Alias animi dolor in, maiores natus.
                                    </p>
                                </div>
                            </a>
                        </div>
                        <div class="timeline">
                            <a href="#" class="timeline-content">
                                <span class="timeline-year">AKHIR</span>
                                <div class="timeline-icon">
                                    <i class="fa fa-edit"></i>
                                </div>
                                <div class="content">
                                    <h3 class="title">Skripsi</h3>
                                    <p class="description">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias animi dolor in, maiores natus ipsum dolor sit amet, consectetur adipisicing elit. Alias animi dolor in, maiores natus.
                                    </p>
                                </div>
                            </a>
                        </div>
                        
                        
                    </div>
                </div>
            </div>
        </div>

        <h1>ALL PROGRESS</h1>
        <div class="progressBar">
            <div class="lingkaranLuar">
                <div class="LingkaranDalam">
                    <div id="jmlhProgres">
                        100%
                    </div>
                </div>
            </div>

            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="390px" height="390px">
                <defs>
                   <linearGradient id="GradientColor">
                      <stop offset="0%" stop-color="#e91e63" />
                      <stop offset="100%" stop-color="#673ab7" />
                   </linearGradient>
                </defs>
                <circle cx="194" cy="195" r="180" stroke-linecap="round" />
        </svg>
        </div>

        <div class="calendar">
            <div class="bungkus">
                <button id="tmbl-prev">
                    <
                </button>
                <div class="blnThn" id="blnThn"></div>
                <button id="tmbl-next">
                    >
                </button>
            </div>
            <div class="hari">
                <div class="day">MON</div>
                <div class="day">TUE</div>
                <div class="day">WED</div>
                <div class="day">THU</div>
                <div class="day">FRI</div>
                <div class="day">SAT</div>
                <div class="day">SUN</div>
            </div>
            <div class="dates" id="dates"></div>
        </div>

        <footer>
            <div class="container my-5">
                <!-- Footer -->
                <footer class="text-center text-white" style="background-color: none">
                  <!-- Grid container -->
                  <div class="container">
                    <!-- Section: Links -->
                    <section class="mt-5">
                      <!-- Grid row-->
                      <div class="row text-center d-flex justify-content-center pt-5">
                        <!-- Grid column -->
                        <div class="col-md-2">
                          <h6 class="text-uppercase font-weight-bold">
                            <a href="#!" class="text-white">About us</a>
                          </h6>
                        </div>
                        <!-- Grid column -->
              
                        <!-- Grid column -->
                        <div class="col-md-2">
                          <h6 class="text-uppercase font-weight-bold">
                            <a href="#!" class="text-white">Products</a>
                          </h6>
                        </div>
                        <!-- Grid column -->
              
                        <!-- Grid column -->
                        <div class="col-md-2">
                          <h6 class="text-uppercase font-weight-bold">
                            <a href="#!" class="text-white">Awards</a>
                          </h6>
                        </div>
                        <!-- Grid column -->
              
                        <!-- Grid column -->
                        <div class="col-md-2">
                          <h6 class="text-uppercase font-weight-bold">
                            <a href="#!" class="text-white">Help</a>
                          </h6>
                        </div>
                        <!-- Grid column -->
              
                        <!-- Grid column -->
                        <div class="col-md-2">
                          <h6 class="text-uppercase font-weight-bold">
                            <a href="#!" class="text-white">Contact</a>
                          </h6>
                        </div>
                        <!-- Grid column -->
                      </div>
                      <!-- Grid row-->
                    </section>
                    <!-- Section: Links -->
              
                    <hr class="my-5" />
              
                    <!-- Section: Text -->
                    <section class="mb-5">
                      <div class="row d-flex justify-content-center">
                        <div class="col-lg-8">
                          <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt
                            distinctio earum repellat quaerat voluptatibus placeat nam,
                            commodi optio pariatur est quia magnam eum harum corrupti
                            dicta, aliquam sequi voluptate quas.
                          </p>
                        </div>
                      </div>
                    </section>
                    <!-- Section: Text -->
              
                    <!-- Section: Social -->
                    <section class="text-center mb-5">
                      <a href="" class="text-white me-4">
                        <i class="fab fa-facebook-f"></i>
                      </a>
                      <a href="" class="text-white me-4">
                        <i class="fab fa-twitter"></i>
                      </a>
                      <a href="" class="text-white me-4">
                        <i class="fab fa-google"></i>
                      </a>
                      <a href="" class="text-white me-4">
                        <i class="fab fa-instagram"></i>
                      </a>
                      <a href="" class="text-white me-4">
                        <i class="fab fa-linkedin"></i>
                      </a>
                      <a href="" class="text-white me-4">
                        <i class="fab fa-github"></i>
                      </a>
                    </section>
                    <!-- Section: Social -->
                  </div>
                  <!-- Grid container -->
              
                  <!-- Copyright -->
                  <div
                       class="text-center p-3"
                       style="background-color: rgba(0, 0, 0, 0.2)"
                       >
                    © 2020 Copyright:
                    <a class="text-white" href="https://mdbootstrap.com/"
                       >MDBootstrap.com</a
                      >
                  </div>
                  <!-- Copyright -->
                </footer>
                <!-- Footer -->
              </div>
        </footer>

            
    </div>

    <script type="module" src="scripts/main-menu.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    
</body>
</html>

<?php  } else {
    header("Location: ../TA-RPL/login.php");
    //header("Location: ../main-menu.php");
    exit;
}
