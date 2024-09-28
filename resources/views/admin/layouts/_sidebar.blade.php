 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

     <ul class="sidebar-nav" id="sidebar-nav">

         <li class="nav-item">
             <a class="nav-link " href="{{ url('admin/dashboard') }}">
                 <i class="bi bi-grid"></i>
                 <span>Dashboard </span>
             </a>
         </li><!-- End Dashboard Nav -->
         <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#Employee-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Employee</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="Employee-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('addemployee') }}">
                        <i class="bi bi-circle"></i><span>Add Employee</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('viewempdata') }}">
                        <i class="bi bi-circle"></i><span>View Employee</span>
                    </a>
                </li>
            </ul>
        </li>
         <li class="nav-item">
             <a class="nav-link collapsed" data-bs-target="#ledger-nav" data-bs-toggle="collapse" href="#">
                 <i class="bi bi-menu-button-wide"></i><span>A/c Ledger</span><i class="bi bi-chevron-down ms-auto"></i>
             </a>
             <ul id="ledger-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                 <li>
                     <a href="{{ route('addledger') }}">
                         <i class="bi bi-circle"></i><span>Create Ledger</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('viewledger') }}">
                         <i class="bi bi-circle"></i><span>View Ledger</span>
                     </a>
                 </li>
                 <li>
                    <a href="{{ route('reciept') }}">
                        <i class="bi bi-circle"></i><span>Reciept</span>
                    </a>
                </li>
                
             </ul>
         </li>
         <li class="nav-item">
             <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                 <i class="bi bi-menu-button-wide"></i><span>Master</span><i class="bi bi-chevron-down ms-auto"></i>
             </a>
             <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                 <li>
                     <a href="{{ route('branch') }}">
                         <i class="bi bi-circle"></i><span>Add Branch</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('viewbranch') }}">
                         <i class="bi bi-circle"></i><span>View Branch</span>
                     </a>
                 </li>
             </ul>
         </li><!-- End Components Nav -->
         <li class="nav-item">
             <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                 <i class="bi bi-journal-text"></i><span>Stock</span><i class="bi bi-chevron-down ms-auto"></i>
             </a>
             <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                 <li>
                     <a href="{{ route('addstock') }}">
                         <i class="bi bi-circle"></i><span>Add Stock</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('viewstock') }}">
                         <i class="bi bi-circle"></i><span>View Stock</span>
                     </a>
                 </li>
                 

             </ul>
         </li><!-- End Forms Nav -->
         <li class="nav-item">
             <a class="nav-link collapsed" data-bs-target="#booking-lead" data-bs-toggle="collapse" href="#">
                 <i class="bi bi-journal-text"></i><span>Booking</span><i class="bi bi-chevron-down ms-auto"></i>
             </a>
             <ul id="booking-lead" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                 <li>
                     <a href="{{ route('booking') }}">
                         <i class="bi bi-circle"></i><span>Add Booking</span>
                     </a>
                 </li>
                 <li>
                    <a href="{{ route('viewbooking') }}">
                        <i class="bi bi-circle"></i><span>View Booking</span>
                    </a>
                </li>
             </ul>
         </li><!-- End Forms Nav -->
         <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#delivary-lead" data-bs-toggle="collapse" href="#">
                <i class="bi bi-journal-text"></i><span>Delivary</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="delivary-lead" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                
                <li>
                   <a href="{{ route('viewdelivary') }}">
                       <i class="bi bi-circle"></i><span>View Delivary</span>
                   </a>
               </li>
            </ul>
        </li><!-- End Forms Nav -->
         <li class="nav-item">
             <a class="nav-link collapsed" data-bs-target="#old-lead" data-bs-toggle="collapse" href="#">
                 <i class="bi bi-journal-text"></i><span>Contact Data</span><i class="bi bi-chevron-down ms-auto"></i>
             </a>
             <ul id="old-lead" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                 <li>
                     <a href="{{ route('addlead1') }}">
                         <i class="bi bi-circle"></i><span>Add Contact</span>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('viewleaddata1') }}">
                         <i class="bi bi-circle"></i><span>View Contact</span>
                     </a>
                 </li>
                 <li>
                    <a href="{{ route('hotleaddata') }}">
                        <i class="bi bi-circle"></i><span>Hot Lead</span>
                    </a>
                </li>
                 <li>
                    <a href="{{ route('vistordata') }}">
                        <i class="bi bi-circle"></i><span>View Visitor</span>
                    </a>
                </li>
             </ul>
         </li><!-- End Forms Nav -->
         <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#finance-lead" data-bs-toggle="collapse" href="#">
                <i class="bi bi-journal-text"></i><span>Finance</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="finance-lead" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{route('addfinancefile')}}">
                        <i class="bi bi-circle"></i><span>Create File</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('viewfinancefile')}}">
                        <i class="bi bi-circle"></i><span>View details</span>
                    </a>
                </li>
                
            </ul>
        </li><!-- End Forms Nav -->
         <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#workshop-lead" data-bs-toggle="collapse" href="#">
              <i class="bi bi-journal-text"></i><span>WorkShop</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="workshop-lead" class="nav-content collapse " data-bs-parent="#sidebar-nav">
              <li>
                  <a href="#">
                      <i class="bi bi-circle"></i><span>New Job Card</span>
                  </a>
              </li>
              <li>
                  <a href="#">
                      <i class="bi bi-circle"></i><span>View Contact</span>
                  </a>
              </li>
          </ul>
      </li><!-- End Forms Nav -->

         <li class="nav-item">
             <a class="nav-link collapsed" href="{{ route('trafficchallan') }}">
                 <i class="bi bi-stoplights-fill"></i>
                 <span>Traffic Challan</span>
             </a>
         </li>



     </ul>

 </aside><!-- End Sidebar-->
