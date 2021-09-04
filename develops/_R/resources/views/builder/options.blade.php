<div class="form-group col-md-12" style="margin-top: 7px">
    <div class="form-control" style="border-color: transparent;padding-left: 0px">
        <label style="font-size: 18px; color: #f50057">Option Generate</label>
    </div>
</div>
<div class="table-responsive col-md-12">
    <table class="table table-striped table-bordered" id="table222" style="@if(!empty($entity)) {{ 'max-width: 900px' }} @else {{'max-width: 300px'}} @endif">
        <thead class="no-border">
        <tr>

            <th>Generate All</th>
            @if(!empty($entity))
                <th>Entities (Name, Icon, Option, Blade...)</th>
                <th>Database structure</th>
                <th>Relationship</th>
            @endif
        </tr>
        </thead>
        <tbody class="no-border-x no-border-y">
        <tr class="item" style="display: table-row">
            <td style="vertical-align: middle">
                <div class="checkbox" style="text-align: center">
                    <label style="padding-left: 0px">
                        <input type="checkbox" checked class="flat-red"/>
                    </label>
                </div>
            </td>
            @if(!empty($entity))
            <td style="vertical-align: middle">
                <div class="checkbox" style="text-align: center">
                    <label style="padding-left: 0px">
                        <input type="checkbox" checked class="flat-red"/>
                    </label>
                </div>
            </td>
            <td style="vertical-align: middle">
                <div class="checkbox" style="text-align: center">
                    <label style="padding-left: 0px">
                        <input type="checkbox" checked class="flat-red"/>
                    </label>
                </div>
            </td>
            <td style="vertical-align: middle">
                <div class="checkbox" style="text-align: center">
                    <label style="padding-left: 0px">
                        <input type="checkbox" checked class="flat-red"/>
                    </label>
                </div>
            </td>
            @endif
        </tr>
        </tbody>
    </table>
</div>
