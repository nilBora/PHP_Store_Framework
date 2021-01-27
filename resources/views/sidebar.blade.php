<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        @foreach ($sidebar->getItems() as $item)
        <li class="nav-item @if($item->hasItems())) has-treeview @endif">
            <a href="{{$item->getHref()}}" class="nav-link @if($item->isActive()) active @endif">
                <i class="nav-icon fas fa-{{$item->getIcon()}}"></i>
                <p>
                    {{$item->getCaption()}}
                    @if ($item->hasLabel())
                        <span class="right badge badge-danger">{{$item->getLabel()}}</span>
                    @endif
                </p>
            </a>
            @if ($item->hasItems())
                <ul class="nav nav-treeview">
                    @foreach ($item->getItems() as $subRow)
                        <li class="nav-item">
                            <a href="{{$subRow->getHref()}}" class="nav-link @if($subRow->isActive()) active @endif">
                                <i class="far nav-icon @if($subRow->hasIcon()) {{$subRow->getIcon()}} @else fa-circle @endif"></i>
                                <p>{{$subRow->getCaption()}}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
        @endforeach
{{--        <li class="nav-item has-treeview">--}}
{{--            <a href="#" class="nav-link">--}}
{{--                <i class="nav-icon fas fa-copy"></i>--}}
{{--                <p>--}}
{{--                    Layout Options--}}
{{--                    <i class="fas fa-angle-left right"></i>--}}
{{--                    <span class="badge badge-info right">6</span>--}}
{{--                </p>--}}
{{--            </a>--}}
{{--            <ul class="nav nav-treeview">--}}
{{--                <li class="nav-item">--}}
{{--                    <a href="pages/layout/top-nav.html" class="nav-link">--}}
{{--                        <i class="far fa-circle nav-icon"></i>--}}
{{--                        <p>Top Navigation</p>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a href="pages/layout/top-nav-sidebar.html" class="nav-link">--}}
{{--                        <i class="far fa-circle nav-icon"></i>--}}
{{--                        <p>Top Navigation + Sidebar</p>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a href="pages/layout/boxed.html" class="nav-link">--}}
{{--                        <i class="far fa-circle nav-icon"></i>--}}
{{--                        <p>Boxed</p>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a href="pages/layout/fixed-sidebar.html" class="nav-link">--}}
{{--                        <i class="far fa-circle nav-icon"></i>--}}
{{--                        <p>Fixed Sidebar</p>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a href="pages/layout/fixed-topnav.html" class="nav-link">--}}
{{--                        <i class="far fa-circle nav-icon"></i>--}}
{{--                        <p>Fixed Navbar</p>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a href="pages/layout/fixed-footer.html" class="nav-link">--}}
{{--                        <i class="far fa-circle nav-icon"></i>--}}
{{--                        <p>Fixed Footer</p>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a href="pages/layout/collapsed-sidebar.html" class="nav-link">--}}
{{--                        <i class="far fa-circle nav-icon"></i>--}}
{{--                        <p>Collapsed Sidebar</p>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--            </ul>--}}
{{--        </li>--}}
    </ul>
</nav>
