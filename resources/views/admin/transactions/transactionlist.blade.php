
        
        @foreach ($subscription  as $value)
        <tr>
            <td>{{$value->hotel_name}}</td>
            <td>{{date('d-m-Y', strtotime($value->created_at))}}</td>
            <td>{{date('H:i:s A', strtotime($value->created_at))}}</td>
            <td>{{$value->transection_id}}</td>
            <td>{{!empty($value->amount) ? '$'.$value->amount : ''}}</td>
        </tr>
        @endforeach 
        
    