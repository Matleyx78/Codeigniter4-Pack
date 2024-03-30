<?php
namespace Matleyx\CI4P\Cells;

use Matleyx\CI4P\Models\MenuItemsModel;

class MenuCell
{
    public $menu_laterale;
    public $menu_alto;
    public $string = '';

    public function __construct($stringa = '')
    {
        //inizializzare della variabile $name
        $this->string = $stringa;
    }

    public function menu_laterale($param1 = ''): string
    {
        if ($param1 == '') {$param1 = 'test';}
        $menu_laterale = '
        <nav id="sidebar">
        <div class="p-3 pt-5">
          <a href="#" class="img logo rounded-circle mb-5" style="background-image: url(sb1/images/logo.jpg);"></a>
    <ul class="list-unstyled components mb-5">
      <li class="active">
        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Home</a>
        <ul class="collapse list-unstyled" id="homeSubmenu">
        <li>
            <a href="#">Home 1</a>
        </li>
        <li>
            <a href="#">Home 2</a>
        </li>
        <li>
            <a href="#">Home 3</a>
        </li>
        </ul>
      </li>
      <li>
          <a href="#">About</a>
      </li>
      <li>
      <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Pages</a>
      <ul class="collapse list-unstyled" id="pageSubmenu">
        <li>
            <a href="#">Page 1</a>
        </li>
        <li>
            <a href="#">Page 2</a>
        </li>
        <li>
            <a href="#">Page 3</a>
        </li>
      </ul>
      </li>
      <li>
      <a href="#">Portfolio</a>
      </li>
      <li>
      <a href="#">Contact</a>
      </li>
    </ul>

    <div class="footer">
        <p><!-- Link back to Colorlib can\'t be removed. Template is licensed under CC BY 3.0. -->
                  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved
                                            <!-- Link back to Colorlib can\'t be removed. Template is licensed under CC BY 3.0. --></p>
    </div>

  </div>
</nav>
        ';
        return $menu_laterale;
    }

    public function menu_alto($param1 = ''): string
    {
        if ($param1 == '') {$param1 = 'test';}
        $menu_alto = '
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">

            <button type="button" id="sidebarCollapse" class="btn btn-primary">
              <i class="fa fa-bars"></i>
              <span class="sr-only">Toggle Menu</span>
            </button>
            <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="nav navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home'.$param1.'</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Portfolio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        ';
        return $menu_alto;
    }    
}
