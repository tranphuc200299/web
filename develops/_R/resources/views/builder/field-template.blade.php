<td style="vertical-align: middle" xmlns="http://www.w3.org/1999/html">
    <div class="h-move"><i class="fa fa-arrows" aria-hidden="true"></i></div>
</td>
<td style="vertical-align: middle">
    @php
        $readOnly = ['id', 'created_by', 'created_at', 'updated_at'];
    @endphp
    <input type="text"
           @if(!empty($field['name']) && in_array($field['name'], $readOnly)) readonly @endif
           value="{{ $field['name']?? '' }}" style="width: 100%" required class="form-control txtFieldName"/>
</td>
<td style="vertical-align: middle">
    @php $dbType=[
        'uuid_primary' => 'Primary Key Uuid',
        'increments' => 'Increments',
        'uuid' => 'Uuid v4',
        'integer' => 'Integer',
        'smallInteger' => 'SmallInteger',
        'bigInteger' => 'BigInteger',
        'double' => 'Integer',
        'longText' => 'LongText',
        'float' => 'Float',
        'decimal' => 'Decimal',
        'boolean' => 'Boolean',
        'string' => 'String',
        'char' => 'Char',
        'text' => 'Text',
        'mediumText' => 'MediumText',
        'datetime' => 'DateTime',
        'datetimetz' => 'DateTimeTZ',
        'date' => 'Date',
        'time' => 'Time',
        'timeTz' => 'TimeTz',
        'timestamp' => 'Timestamp',
        'timestampTz' => 'Timestamp',
    ] @endphp
    <select class="form-control txtdbType" style="width: 100%">
        @foreach($dbType as $key => $name)
            <option value="{{ $key }}" @if((!empty($field['dbType']) && $field['dbType'] == $key) || (empty($field['dbType']) && $key == 'string')) selected @endif >
                {{ $name }}
            </option>
        @endforeach
    </select>

    <input type="text" class="form-control dbValue txtDbValue" style="display: none"
           placeholder=""/>
</td>
<td style="vertical-align: middle">
    <input type="text" value="{{ $field['txtLabel']?? '' }}" class="form-control txtLabel"/>
</td>
<td style="vertical-align: middle">
    @php $htmlType=[
        'text' => 'Text',
        'uuid' => 'Uuid',
        'number' => 'Number',
        'email' => 'Email',
        'password' => 'Password',
        'textArea' => 'TextArea',
        'editor' => 'Editor',
        'datetime' => 'Date Time',
        'date' => 'Date',
        'time' => 'Time',
        'file' => 'File',
        'image' => 'Image',
        'select' => 'Select',
        'radio' => 'Radio',
        'checkbox' => 'Checkbox',
        'toggle-switch' => 'Toggle',
        'select2-jax' => 'Select2 Ajax',
    ] @endphp

    <select class="form-control drdHtmlType" style="width: 100%">
        @foreach($htmlType as $key => $name)
            <option value="{{ $key }}" @if(!empty($field['htmlType']) && $field['htmlType'] == $key) selected @endif >
                {{ $name }}
            </option>
        @endforeach
    </select>
    <textarea class="form-control htmlValue txtHtmlValue w-100"
              @if(empty($field['htmlType']) || !in_array($field['htmlType'], ['select', 'radio', 'checkbox'])) style="display: none;" @endif
     placeholder="key:value (Enter)">{!! $field['valueList']?? ''  !!}</textarea>
</td>
<td style="vertical-align: middle">
    @php $fakerOptions=[
        "name" => "name",
        "firstName" => "firstName",
        "firstNameMale" => "firstNameMale",
        "firstNameFemale" => "firstNameFemale",
        "lastName" => "lastName",
        "title" => "title",
        "titleMale" => "titleMale",
        "titleFemale" => "titleFemale",
        "citySuffix" => "citySuffix",
        "streetSuffix" => "streetSuffix",
        "buildingNumber" => "buildingNumber",
        "city" => "city",
        "streetName" => "streetName",
        "streetAddress" => "streetAddress",
        "secondaryAddress" => "secondaryAddress",
        "postcode" => "postcode",
        "address" => "address",
        "state" => "state",
        "country" => "country",
        "latitude" => "latitude",
        "longitude" => "longitude",
        "ean13" => "ean13",
        "ean8" => "ean8",
        "isbn13" => "isbn13",
        "isbn10" => "isbn10",
        "phoneNumber" => "phoneNumber",
        "e164PhoneNumber" => "e164PhoneNumber",
        "company" => "company",
        "companySuffix" => "companySuffix",
        "jobTitle" => "jobTitle",
        "creditCardType" => "creditCardType",
        "creditCardNumber" => "creditCardNumber",
        "creditCardExpirationDate" => "creditCardExpirationDate",
        "creditCardExpirationDateString" => "creditCardExpirationDateString",
        "bankAccountNumber" => "bankAccountNumber",
        "swiftBicNumber" => "swiftBicNumber",
        "vat" => "vat",
        "word" => "word",
        "sentence" => "sentence",
        "paragraph" => "paragraph",
        "text" => "text",
        "email" => "email",
        "safeEmail" => "safeEmail",
        "freeEmail" => "freeEmail",
        "companyEmail" => "companyEmail",
        "freeEmailDomain" => "freeEmailDomain",
        "safeEmailDomain" => "safeEmailDomain",
        "userName" => "userName",
        "password" => "password",
        "domainName" => "domainName",
        "domainWord" => "domainWord",
        "tld" => "tld",
        "url" => "url",
        "slug" => "slug",
        "ipv4" => "ipv4",
        "ipv6" => "ipv6",
        "localIpv4" => "localIpv4",
        "macAddress" => "macAddress",
        "unixTime" => "unixTime",
        "dateTime" => "dateTime",
        "dateTimeAD" => "dateTimeAD",
        "iso8601" => "iso8601",
        "dateTimeThisCentury" => "dateTimeThisCentury",
        "dateTimeThisDecade" => "dateTimeThisDecade",
        "dateTimeThisYear" => "dateTimeThisYear",
        "dateTimeThisMonth" => "dateTimeThisMonth",
        "amPm" => "amPm",
        "dayOfMonth" => "dayOfMonth",
        "dayOfWeek" => "dayOfWeek",
        "month" => "month",
        "monthName" => "monthName",
        "year" => "year",
        "century" => "century",
        "timezone" => "timezone",
        "md5" => "md5",
        "sha1" => "sha1",
        "sha256" => "sha256",
        "locale" => "locale",
        "countryCode" => "countryCode",
        "countryISOAlpha3" => "countryISOAlpha3",
        "languageCode" => "languageCode",
        "currencyCode" => "currencyCode",
        "boolean" => "boolean",
        "randomDigit" => "randomDigit",
        "randomDigitNot" => "randomDigitNot",
        "randomDigitNotNull" => "randomDigitNotNull",
        "randomLetter" => "randomLetter",
        "randomAscii" => "randomAscii",
        "macProcessor" => "macProcessor",
        "linuxProcessor" => "linuxProcessor",
        "userAgent" => "userAgent",
        "chrome" => "chrome",
        "firefox" => "firefox",
        "safari" => "safari",
        "opera" => "opera",
        "internetExplorer" => "internetExplorer",
        "windowsPlatformToken" => "windowsPlatformToken",
        "macPlatformToken" => "macPlatformToken",
        "linuxPlatformToken" => "linuxPlatformToken",
        "uuid" => "uuid",
        "mimeType" => "mimeType",
        "fileExtension" => "fileExtension",
        "hexColor" => "hexColor",
        "safeHexColor" => "safeHexColor",
        "rgbColor" => "rgbColor",
        "rgbColorAsArray" => "rgbColorAsArray",
        "rgbCssColor" => "rgbCssColor",
        "safeColorName" => "safeColorName",
        "colorName" => "colorName",
    ]
    @endphp
    <select class="form-control txtFactoryFaker" style="width: 100%">
        <option value=""></option>
        @foreach($fakerOptions as $key => $faker)
            <option value="{{$faker}}" @if(!empty($field['txtFactoryFaker']) && $field['txtFactoryFaker'] == $key) selected @endif>{{ $faker }}</option>
        @endforeach
    </select>
</td>
<td style="vertical-align: middle">
    <input type="text"  value="{{ $field['validations']?? '' }}" class="form-control txtValidation"/>
</td>
<td style="vertical-align: middle">
    <div class="checkbox" style="text-align: center">
        <label style="padding-left: 0px">
            <input type="checkbox"
                   @if(!empty($field['primary'])) checked @endif
                   style="margin-left: 0px!important;" class="flat-red chkPrimary"/>
        </label>
    </div>
</td>
<td style="vertical-align: middle">
    <div class="checkbox" style="text-align: center">
        <label style="padding-left: 0px">
            <input type="checkbox"
                   @if(!empty($field['nullable']) || !isset($field['nullable'])) checked @endif
                   style="margin-left: 0px!important;" class="flat-red chkNullable"/>
        </label>
    </div>
</td>
<td style="vertical-align: middle">
    <div class="checkbox" style="text-align: center">
        <label style="padding-left: 0px">
            <input type="checkbox"
                   @if(!empty($field['unique'])) checked @endif
                   style="margin-left: 0px!important;" class="flat-red chkUnique"/>
        </label>
    </div>
</td>
<td style="vertical-align: middle">
    <div class="checkbox" style="text-align: center">
        <label style="padding-left: 0px">
            <input type="checkbox" style="margin-left: 0px!important;"
                   @if(!empty($field['isForeign'])) checked @endif
                   class="flat-red chkForeign"/>
        </label>
    </div>
</td>
<td style="vertical-align: middle">
    <div class="checkbox" style="text-align: center">
        <label style="padding-left: 0px">
            <input type="checkbox" style="margin-left: 0px!important;" class="flat-red chkSearchable"
               @if(!empty($field['searchable']) || !isset($field['searchable'])) checked @endif
            />
        </label>
    </div>
</td>
<td style="vertical-align: middle">
    <div class="checkbox" style="text-align: center">
        <label style="padding-left: 0px">
            <input type="checkbox" style="margin-left: 0px!important;" class="flat-red chkInForm"
                   @if(!empty($field['inForm']) || !isset($field['inForm'])) checked @endif
            />
        </label>
    </div>
</td>
<td style="vertical-align: middle">
    <div class="checkbox" style="text-align: center">
        <label style="padding-left: 0px">
            <input type="checkbox" style="margin-left: 0px!important;" class="flat-red chkInIndex"
                   @if(!empty($field['inIndex']) || !isset($field['inIndex'])) checked @endif/>
        </label>
    </div>
</td>
<td style="text-align: center;vertical-align: middle">
    <i onclick="removeItem(this)" class="remove fa fa-trash-o"
       style="cursor: pointer;font-size: 20px;color: red"></i>
</td>
