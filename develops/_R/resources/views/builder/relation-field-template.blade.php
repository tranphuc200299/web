<td style="vertical-align: middle">
    <input type="text" class="form-control txtForeignModule" required @if(!empty($relation['foreignModule'])) value="{{$relation['foreignModule']}}" @endif/>
</td>
<td style="vertical-align: middle">
    <input type="text" class="form-control txtForeignModel" required @if(!empty($relation['foreignModel'])) value="{{$relation['foreignModel']}}" @endif/>
</td>
<td style="vertical-align: middle">
    <input type="text" class="form-control txtForeignKey" required @if(!empty($relation['foreignKey'])) value="{{$relation['foreignKey']}}" @endif/>
</td>
<td style="vertical-align: middle">
    @php $relationship =
    [
     '1t1_has_one' => 'Has One (1-1)',
     '1t1_belongs_to' => 'BelongsTo (1-1)',
     'mt1_has_many' => 'Has Many (1-n)',
     'mt1_belongs_to' => 'BelongsTo (n-1)',
     'mtm_belongs_to_many' => 'BelongsTo Many (n-n)'
     ]
    @endphp
    <select class="form-control drdRelationType" style="width: 100%">
        @foreach($relationship as $key => $name)
            <option value="{{$key}}" @if(!empty($relation['relationType']) && $key == $relation['relationType'])
                selected @endif>{{$name}}</option>
        @endforeach
    </select>
    <input type="text"  class="form-control foreignTable txtForeignTable" style="display: none"
           placeholder="Custom Table Name"/>
</td>
<td style="vertical-align: middle">
    <input type="text" class="form-control txtLocalKey" required @if(!empty($relation['localKey'])) value="{{$relation['localKey']}}" @endif/>
</td>
<td style="vertical-align: middle">
    <input type="text" class="form-control txtDisplayName" required @if(!empty($relation['displayName'])) value="{{$relation['displayName']}}" @endif/>
</td>
<td style="vertical-align: middle">
    <input type="text" class="form-control txtDisplayField" required @if(!empty($relation['displayField'])) value="{{$relation['displayField']}}" @endif/>
</td>
<td style="text-align: center;vertical-align: middle">
    <i onclick="removeItem(this)" class="remove fa fa-trash-o"
       style="cursor: pointer;font-size: 20px;color: red"></i>
</td>
