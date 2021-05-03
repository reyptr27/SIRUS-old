@can('telegram')
<li class="treeview {{ set_active(['telegram.message','telegram.photo','telegram.document']) }}">
    <a href="#">
    <i class="fa fa-send"></i> <span>
        Telegram Broadcast
        </span>  
    <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
    </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ set_active(['telegram.message']) }}"><a href="{{ route('telegram.message') }}"><i class="fa fa-envelope-o"></i> Message</a></li>
        <li class="{{ set_active(['telegram.photo']) }}"><a href="{{ route('telegram.photo') }}"><i class="fa fa-file-image-o"></i> Image</a></li>
        <li class="{{ set_active(['telegram.document']) }}"><a href="{{ route('telegram.document') }}"><i class="fa fa-file-o"></i> Document</a></li>
    </ul>
</li>
@endcan