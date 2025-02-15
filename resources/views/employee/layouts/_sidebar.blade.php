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
                 <i class="bi bi-journal-text"></i><span>Lead Management</span><i class="bi bi-chevron-down ms-auto"></i>
             </a>
             <ul id="old-lead" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                 <li>
                     <a href="{{ route('addlead') }}">
                         <i class="bi bi-circle"></i><span>Add Lead</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('viewleaddata') }}">
                         <i class="bi bi-circle"></i><span>Pending Lead</span>
                     </a>
                 </li>

                 <li>
                     <a href="{{ route('callingfollouplead') }}">
                         <i class="bi bi-circle"></i><span>Calling Follow UP Lead</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('visitfollowuplead') }}">
                         <i class="bi bi-circle"></i><span>Visit-Follow-up Lead</span>
                     </a>
                 </li>

                 <li>
                     <a href="{{ route('viewleaddata') }}">
                         <i class="bi bi-circle"></i><span>Wrong Number Lead</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('viewleaddata') }}">
                         <i class="bi bi-circle"></i><span>Not Answer Lead</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('viewleaddata') }}">
                         <i class="bi bi-circle"></i><span>After Visit Reject Lead</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('viewleaddata') }}">
                         <i class="bi bi-circle"></i><span>Not-Intrested Lead</span>
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
                     <a href="{{ route('viewvisitor') }}">
                         <i class="bi bi-circle"></i><span>View Visitor</span>
                     </a>
                 </li>
             </ul>
         </li><!-- End Forms Nav -->
         <li class="nav-item">
             <a class="nav-link collapsed" href="{{route('viewcloudcalldata')}}">
                 <i class="bi bi-person"></i>
                 <span>Cloud Call Data</span>
             </a>
         </li>
     </ul>

 </aside><!-- End Sidebar-->