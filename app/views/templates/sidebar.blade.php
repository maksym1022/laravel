<?php
$menus = Menus::all();

?>
<!--sidebar left start-->
<aside class="sidebar">
	<div id="leftside-navigation" class="nano">
	<ul class="nano-content">
    @foreach($menus as $menu)
    
        @if(SubMenus::where('menu_id',$menu->id)->count()&& Menus::checkPermission($menu->id))
        <li class="sub-menu {{HTML::clever_link($menu->link)}}">
            <a href="javascript:void(0);">
                <i class="fa fa-{{$menu->icon}}"></i><span>{{$menu->titulo}}</span>
                <i class="arrow fa fa-angle-right pull-right"></i>
            </a>
            <ul >
                <?php $submenus = SubMenus::where('menu_id',$menu->id)->get()?>
                 @foreach($submenus as $submenu)
                    @if(Menus::checkPermission($submenu->id,'submenu_id'))
                    <li class="{{HTML::clever_link($submenu->link)}}"><a href="{{asset($submenu->link)}}">{{$submenu->titulo}}</a></li>
                    @endif
                 @endforeach
            </ul>
            
        </li>
        @elseif(Menus::checkPermission($menu->id))
        <li class="{{HTML::clever_link($menu->link)}}">
            <a href="{{asset($menu->link)}}">
                <i class="fa fa-{{$menu->icon}}"></i><span>{{$menu->titulo}}</span>
            </a>
        </li>
        @endif
    @endforeach
	</ul>
</aside>
<!--sidebar left end-->
			