<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? '' : 'collapsed' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        @if (Auth::user()->id == 1)
        <li class="nav-item">
            @php $empRoutes = ['addemployee', 'viewempdata']; @endphp
            <a class="nav-link {{ request()->routeIs($empRoutes) ? '' : 'collapsed' }}" data-bs-target="#Employee-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Employee</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="Employee-nav" class="nav-content collapse {{ request()->routeIs($empRoutes) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('addemployee') }}" class="{{ request()->routeIs('addemployee') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Add Employee</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('viewempdata') }}" class="{{ request()->routeIs('viewempdata') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>View Employee</span>
                    </a>
                </li>
            </ul>
        </li>
        @endif

        <li class="nav-item">
            @php $ledgerRoutes = ['addledger', 'viewledger', 'reciept']; @endphp
            <a class="nav-link {{ request()->routeIs($ledgerRoutes) ? '' : 'collapsed' }}" data-bs-target="#ledger-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>A/c Ledger</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="ledger-nav" class="nav-content collapse {{ request()->routeIs($ledgerRoutes) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('addledger') }}" class="{{ request()->routeIs('addledger') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Create Ledger</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('viewledger') }}" class="{{ request()->routeIs('viewledger') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>View Ledger</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('reciept') }}" class="{{ request()->routeIs('reciept') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Receipt</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            @php $masterRoutes = ['branch', 'viewbranch']; @endphp
            <a class="nav-link {{ request()->routeIs($masterRoutes) ? '' : 'collapsed' }}" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Master</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse {{ request()->routeIs($masterRoutes) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('branch') }}" class="{{ request()->routeIs('branch') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Add Branch</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('viewbranch') }}" class="{{ request()->routeIs('viewbranch') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>View Branch</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            @php $stockRoutes = ['addstock', 'viewstock', 'addstockpaper', 'viewstockpaper', 'stockpaperdetails']; @endphp
            <a class="nav-link {{ request()->routeIs($stockRoutes) ? '' : 'collapsed' }}" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-journal-text"></i><span>Stock</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav" class="nav-content collapse {{ request()->routeIs($stockRoutes) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('addstock') }}" class="{{ request()->routeIs('addstock') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Add Stock</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('viewstock') }}" class="{{ request()->routeIs('viewstock') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>View Stock</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('addstockpaper') }}" class="{{ request()->routeIs('addstockpaper') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Upload Stock Paper</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('viewstockpaper') }}" class="{{ request()->routeIs('viewstockpaper') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>View Stock Paper</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('stockpaperdetails') }}" class="{{ request()->routeIs('stockpaperdetails') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Stock Paper Details</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            @php $bookingRoutes = ['booking', 'viewbooking','view-cancelled-bookings']; @endphp
            <a class="nav-link {{ request()->routeIs($bookingRoutes) ? '' : 'collapsed' }}" data-bs-target="#booking-lead" data-bs-toggle="collapse" href="#">
                <i class="bi bi-journal-text"></i><span>Booking</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="booking-lead" class="nav-content collapse {{ request()->routeIs($bookingRoutes) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('booking') }}" class="{{ request()->routeIs('booking') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Add Booking</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('viewbooking') }}" class="{{ request()->routeIs('viewbooking') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>View Booking</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('view-cancelled-bookings') }}" class="{{ request()->routeIs('view-cancelled-bookings') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Cancelled Bookings</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            @php $deliveryRoutes = ['viewdelivary']; @endphp
            <a class="nav-link {{ request()->routeIs($deliveryRoutes) ? '' : 'collapsed' }}" data-bs-target="#delivary-lead" data-bs-toggle="collapse" href="#">
                <i class="bi bi-journal-text"></i><span>Delivery</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="delivary-lead" class="nav-content collapse {{ request()->routeIs($deliveryRoutes) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('viewdelivary') }}" class="{{ request()->routeIs('viewdelivary') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>View Delivery</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            @php $contactRoutes = ['addlead1', 'showjustdaildata', 'showcloudacalldata', 'qkonnectcalldata', 'viewleaddata1', 'hotleaddata', 'vistordata', 'leadallotment']; @endphp
            <a class="nav-link {{ request()->routeIs($contactRoutes) ? '' : 'collapsed' }}" data-bs-target="#old-lead" data-bs-toggle="collapse" href="#">
                <i class="bi bi-journal-text"></i><span>Contact Data</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="old-lead" class="nav-content collapse {{ request()->routeIs($contactRoutes) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('addlead1') }}" class="{{ request()->routeIs('addlead1') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Add Contact</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('showjustdaildata') }}" class="{{ request()->routeIs('showjustdaildata') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>View Just-dial Data</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('showcloudacalldata') }}" class="{{ request()->routeIs('showcloudacalldata') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>View Cloud Call Data</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('qkonnectcalldata') }}" class="{{ request()->routeIs('qkonnectcalldata') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Qkonnect Call Data</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('viewleaddata1') }}" class="{{ request()->routeIs('viewleaddata1') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>View Contact</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('hotleaddata') }}" class="{{ request()->routeIs('hotleaddata') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Hot Lead</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('vistordata') }}" class="{{ request()->routeIs('vistordata') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>View Visitor</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('leadallotment') }}" class="{{ request()->routeIs('leadallotment') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Allot Lead</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            @php $financeRoutes = ['addfinancefile', 'viewfinancefile', 'viewreadyfordelivaryfile', 'viewdelivaryfile', 'viewdeclinefile']; @endphp
            <a class="nav-link {{ request()->routeIs($financeRoutes) ? '' : 'collapsed' }}" data-bs-target="#finance-lead" data-bs-toggle="collapse" href="#">
                <i class="bi bi-journal-text"></i><span>Finance</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="finance-lead" class="nav-content collapse {{ request()->routeIs($financeRoutes) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('addfinancefile') }}" class="{{ request()->routeIs('addfinancefile') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Create File</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('viewfinancefile') }}" class="{{ request()->routeIs('viewfinancefile') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>View Details</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('viewreadyfordelivaryfile') }}" class="{{ request()->routeIs('viewreadyfordelivaryfile') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Ready for Delivery</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('viewdelivaryfile') }}" class="{{ request()->routeIs('viewdelivaryfile') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>View Delivered</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('viewdeclinefile') }}" class="{{ request()->routeIs('viewdeclinefile') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>View Decline File</span>
                    </a>
                </li>
            </ul>
        </li>

        @if (Auth::user()->id == 1 || Auth::user()->id == 18 || Auth::user()->id == 21)
        <li class="nav-item">
            @php $dtoRoutes = ['adddtofile', 'viewdtofile', 'viewonlinedtofile']; @endphp
            <a class="nav-link {{ request()->routeIs($dtoRoutes) ? '' : 'collapsed' }}" data-bs-target="#dto-lead" data-bs-toggle="collapse" href="#">
                <i class="bi bi-journal-text"></i><span>DTO File</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="dto-lead" class="nav-content collapse {{ request()->routeIs($dtoRoutes) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('adddtofile') }}" class="{{ request()->routeIs('adddtofile') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Add DTO File</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('viewdtofile') }}" class="{{ request()->routeIs('viewdtofile') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>View DTO File</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('viewonlinedtofile') }}" class="{{ request()->routeIs('viewonlinedtofile') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>View Online File</span>
                    </a>
                </li>
            </ul>
        </li>
        @endif

        <li class="nav-item">
            @php $purchaseRoutes = ['addvendor', 'viewinspection']; @endphp
            <a class="nav-link {{ request()->routeIs($purchaseRoutes) ? '' : 'collapsed' }}" data-bs-target="#purchase-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-journal-text"></i><span>Purchase</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="purchase-nav" class="nav-content collapse {{ request()->routeIs($purchaseRoutes) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('addvendor') }}" class="{{ request()->routeIs('addvendor') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Add Vendor</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('viewinspection') }}" class="{{ request()->routeIs('viewinspection') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>View Inspection</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            @php $workshopRoutes = ['inspection', 'viewinspection']; @endphp
            <a class="nav-link {{ request()->routeIs($workshopRoutes) ? '' : 'collapsed' }}" data-bs-target="#workshop-lead" data-bs-toggle="collapse" href="#">
                <i class="bi bi-journal-text"></i><span>Workshop</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="workshop-lead" class="nav-content collapse {{ request()->routeIs($workshopRoutes) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('inspection') }}" class="{{ request()->routeIs('inspection') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Add Inspection</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('viewinspection') }}" class="{{ request()->routeIs('viewinspection') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>View Inspection</span>
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</aside>```