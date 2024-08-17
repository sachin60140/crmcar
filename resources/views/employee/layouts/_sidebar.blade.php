 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

     <ul class="sidebar-nav" id="sidebar-nav">

         <li class="nav-item">
             <a class="nav-link " href="{{ url('employee/dashboard') }}">
                 <i class="bi bi-grid"></i>
                 <span>Dashboard </span>
             </a>
         </li><!-- End Dashboard Nav -->
         
         <li class="nav-item">
             <a class="nav-link collapsed" data-bs-target="#old-lead" data-bs-toggle="collapse" href="#">
                 <i class="bi bi-journal-text"></i><span>Contact Data</span><i class="bi bi-chevron-down ms-auto"></i>
             </a>
             <ul id="old-lead" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                 <li>
                     <a href="{{ route('addlead') }}">
                         <i class="bi bi-circle"></i><span>Add Contact</span>
                     </a>
                 </li>
                 
             </ul>
         </li><!-- End Forms Nav -->
         <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#visitor-lead" data-bs-toggle="collapse" href="#">
                <i class="bi bi-journal-text"></i><span>Visitor</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="visitor-lead" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('visitor') }}">
                        <i class="bi bi-circle"></i><span>Add Visitor</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('viewleaddata') }}">
                        <i class="bi bi-circle"></i><span>View Contact</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Forms Nav -->
     </ul>

 </aside><!-- End Sidebar-->
