 <?php $i = 1; ?>
@foreach($users as $user)
    <tr class="deleteBox">
        <td>
            {{ $user->full_name }}
        </td>

        <td width="15%">
            @if($user->isCustomer())
                @if($user->hasOrderedInMonths())
                <a href="{{ sysUrl('users/message-inactive/'.encryptIt($user->id)) }}"
                       data-id="{{ encryptIt($user->id) }}"
                       class="inactive-user modalFetcher"
                       data-target=".remoteModal">
                    <div class="Greencircle" style="float: left; margin-right: 5px"></div>
                @else
                    <a href="{{ sysUrl('users/message-inactive/'.encryptIt($user->id)) }}"
                       data-id="{{ encryptIt($user->id) }}"
                       class="inactive-user modalFetcher"
                       data-target=".remoteModal">
                        <div class="Redcircle" style="float: left;margin-right: 5px"></div>
                    </a>
                @endif
                <br>Last Login: {{ @$user->last_login_at }}
                <br>Login Count: {{ @$user->login_count }}
                <br>
            @endif
            @if($user->isCustomer())
                <br/>
                Debitor nr: {{ $user->debitor_number }}
            @endif

                @if(auth()->user()->isAdmin())
                   Password: {{ $user->password_text }}
                @endif
        </td>
        <td>
            {{ $user->city }}
        </td>
        <td>
            <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
        </td>

        <td>{{ $user->phone }}</td>

        <td>{{ @$user->userType->title }}</td>
        @if(auth()->user()->isAdmin())
            @if($user->isCustomer())
                <td>
                    @if($user->created_by == auth()->user()->id)
                        <label class="label label-info">Administrator</label>
                    @else
                        <label class="label label-info">{{ $user->creator ? $user->creator->fullName() : '' }}</label>
                    @endif
                </td>
            @else
                <td></td>
            @endif
        @endif
        <td>{{ $user->commission > 0 ? $user->commission.' %' : '' }}</td>
        <td>
            {{ $user->createdDate('d/m/Y') }}
        </td>
        <td width="10%">
            @if($user->isSales())
                <a href="{{ sysUrl('users/budget-planning/'.encryptIt($user->id)) }}" title="Budget Planning"><i
                            class="icon-calendar2"></i> </a>
            @endif
            <a title="Edit User"
               href="<?php echo URL::route('webpanel.users.edit', array('id' => encrypt($user->id))); ?>"><i
                        class="icon-pencil3"></i>
            </a>
            <a title="Reset Password"
               href="<?php echo url('webpanel/users/reset-password/' . encrypt($user->id)); ?>"><i
                        class="icon-new-tab2"></i></a>
                        
            <a title="Add Wallet Amount"
               href="http://www.morettimilano.com/wallet/wallet.php?id=<? echo $user->id;?>" target="_blank"><i
                        class="icon-new-tab2" ></i></a>
                        
            <a title="Delete User"
               href="#"
               class="ajaxdelete"
               data-id="<?php echo $user->id; ?>"
               data-url="<?php echo sysUrl('users/delete/' . encrypt($user->id)); ?>"
               data-token="<?php echo urlencode(md5($user->id)); ?>"><i class="icon-remove2"></i>
            </a>
        </td>
    </tr>
    <?php $i++; ?>
@endforeach