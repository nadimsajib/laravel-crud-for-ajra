@if(isset($customer->name))

    <table>
        <tr>
            <td><strong>Name:</strong></td>
            <td>{{$customer->name}}</td>
        </tr>
        <tr>
            <td><strong>Country:</strong></td>
            <td>{{$customer->country->name }}</td>
        </tr>
        <tr>
            <td><strong>City:</strong></td>
            <td>{{ $customer->city->name }}</td>
        </tr>
        <tr>
            <td><strong>Language Skills:</strong></td>
            <td>{{ str_replace("c_plus","c++",$customer->lang_skills) }}</td>
        </tr>
        <tr>
            <td><strong>Resume:</strong></td>
            <td><a href="{{URL::to('/')}}{{ $customer->resume }}" target="_blank">Click to download resume</a></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right "><a
                        href="{{ route('customers.index') }}" class="btn btn-danger">OK</a>
            </td>
        </tr>
    </table>
@endif