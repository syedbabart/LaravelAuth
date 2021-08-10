<table>
@php
    if($user_priveleges['canChangeStatus']){
        $r='canadduser';
    }
    else{
        $r='cannotadduser';
    }
@endphp

<td> {{$r}} </td>

</table>