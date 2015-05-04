<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>

        {!! HTML::style('/css/manage/admin.css') !!}
        {!! HTML::style('/css/manage/form.css') !!}
        {!! HTML::style('/css/manage/add_sleep_study.css') !!}

        {!! HTML::script('/js/jquery-1.6.2.min.js') !!}
        {!! HTML::script('/js/manage/validation.js') !!}
        {!! HTML::script('/js/manage/wufoo.js') !!}
        {!! HTML::script('/js/manage/add_image.js') !!}
        {!! HTML::script('/js/manage/autocomplete.js') !!}
        {!! HTML::script('/js/manage/autocomplete_local.js') !!}
        {!! HTML::script('/js/manage/add_image_sleep_study.js') !!}
    </head>

    <body>
        <div id="loader" style="position:absolute;width:100%; height:98%; display:none;">
            <img style="margin:100px 0 0 45%" src="/img/DSS-ajax-animated_loading-gif.gif" />
        </div>

        <br /><br />

        @if (!empty($alert))
            <script>
                alert('{{ $alert }}');
            </script>
        @endif

        @if (!empty($message))
            <div align="center" class="red">
                {{ $message }}
            </div>
        @endif

        @if (!empty($closePopup))
            <script>
                parent.disablePopup1();
                loc = parent.window.location.href;
                loc = loc.replace("#", "");
                parent.window.location = loc;
            </script>
        @endif

        <form name="imagefrm" action="/manage/image/add" method="post" onSubmit="return imageabc(this);" enctype="multipart/form-data">
            <input name="flow" type="hidden" value="{{ $flow or '' }}" />
            <input type="hidden" name='add' value='1'>
            <input type="hidden" name='sh' value="{{ $sh or '' }}">
            <input type="hidden" name="pid" value="{{ $patientId }}">
            <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
                <tr>
                    <td colspan="2" class="cat_head">
                        {{ $buttonText }} Image
                        
                        @if (!empty($title))
                            &quot;{{ $title }}&quot;
                        @endif
                    </td>
                </tr>
                <tr>
                    <td valign="top" colspan="2" class="frmhead">
                        <ul>
                            <li id="foli8" class="complex">
                                <span>
                                    Image Type
                                    &nbsp;&nbsp;

                                    @if (!empty($showBlock['imageTypes']))
                                        <input type="hidden" id="imagetypeid" name="imagetypeid" value="{{ $sh or '' }}">

                                        @foreach($imageTypes as $imageType)
                                            @if ($imageTypeId == $imageType->imagetypeid)
                                                {{ $imageType->imagetype }}
                                            @endif
                                        @endforeach
                                    @else
                                        <select id="imagetypeid" name="imagetypeid" class="field text addr tbox" >
                                            <option value=""></option>

                                            @foreach ($imageTypes as $imageType)
                                                <option value="{{ $imageType->imagetypeid or '' }}" {{ (($imageTypeId == $imageType->imagetypeid) || !empty($it) && $it == $imageType->imagetypeid) ? ' selected' : '' }}>
                                                    {{ $imageType->imagetype }}
                                                </option>
                                            @endforeach

                                            <option value="0">Clinical Photos (Pre-Tx Batch)</option>
                                        </select>
                                    @endif

                                </span> 
                                <span id="req_0" class="req">*</span>
                            </li>
                        </ul>
                    </td>
                </tr>

                @if (!empty($flowPg1))
                    @if (!empty($flowPg1->lomn_imgid))
                        <tr class="image_sect lomn_update" {{ ($sh == 7) ? '' : 'style="display:none;"' }}>
                            <td valign="top" colspan="2" class="frmhead">
                                <input type="checkbox" value="1" name="lomn_update" /> Use this LOMN for insurance claims
                            </td>
                        </tr>
                    @endif

                    @if (!empty($flowPg1->rx_imgid))
                        <tr class="image_sect rx_update" {{ ($sh == 6) ? '' : 'style="display:none;"' }}>
                            <td valign="top" colspan="2" class="frmhead">
                                <input type="checkbox" value="1" name="rx_update" /> Use this RX for insurance claims
                            </td>
                        </tr>
                    @endif

                    @if (!empty($flowPg1->rxlomn_imgid))
                        <tr class="image_sect rxlomn_update" {{ ($sh == 14) ? '' : 'style="display:none;"' }}>
                            <td valign="top" colspan="2" class="frmhead">
                                <input type="checkbox" value="1" name="rxlomn_update" /> Use this LOMN / Rx. for insurance claims
                            </td>
                        </tr>
                    @endif
                @endif

                <tr class="image_sect"> 
                    <td valign="top" colspan="2" class="frmhead">
                        <ul>
                            <li id="foli8" class="complex">    
                                <span>
                                    Title
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input id="title" name="title" type="text" class="field text addr tbox" value="{{ $title or '' }}" maxlength="255"/>
                                </span>
                                <span id="req_0" class="req">*</span>
                            </li>
                        </ul>
                    </td>
                </tr>
                <tr id="orig_file" class="image_sect"> 
                    <td valign="top" colspan="2" class="frmhead">
                        <ul>
                            <li id="foli8" class="complex">    
                                <span>
                                    Image
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                    @if (!empty($imageFile))
                                        <a href="display_file/{{ $imageFile or '' }}" target="_blank">
                                            <b>Preview</b>
                                        </a>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                    @endif

                                    <input type="file" name="image_file" value="" size="26" />
                                    <input type="hidden" name="image_file_old" value="{{ $imageFile or '' }}" />
                                </span>
                                <span id="req_0" class="req">*</span>
                            </li>
                        </ul>
                    </td>
                </tr>
                <tr id="extra_files" style="display:none;" class="image_sect">
                    <td colspan="2" class="frmhead">

                        @for ($i = 1; $i <= 9; $i++)
                            <label style="width:100px; float:left; display:block;">{{ $labels[$i] }}</label>
                            <input type="file" name="image_file_{{ $i }}" value="" size="26" /><br />
                        @endfor

                    </td>
                </tr>
                <tr class="image_sect">
                    <td  colspan="2" align="center">
                        <span class="red">
                            * Required Fields
                        </span><br />
                        <input type="hidden" name="imagesub" value="1" />
                        <input type="hidden" name="ed" value="{{ $image->imageid or '' }}" />
                        <input type="hidden" name="return" value="{{ $return }}" />
                        <input type="hidden" name="field" value="{{ $field }}" />
                        <input type="hidden" name="_token" value="{{ Session::get('_token') }}">
                        <input type="submit" value=" {{ $buttonText }} Image" class="button" />
                    </td>
                </tr>
            </table>
        </form>
        <table>
            <tr id="sleep_study" style="display:none;">
                <td colspan="2" class="frmhead">
                    <table class="sleeplabstable" width="108" align="center" style="float:left; margin: 0;line-height:22px;">
                        <tr>
                            <td valign="top" class="odd">
                                Date
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="even">
                                Sleep Test Type
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="odd">
                                Place
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="even">
                                Diagnosis
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="odd">
                                Diagnosing Phys.
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="even">
                                Diagnosing NPI#
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="odd">
                                File
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="even">
                                AHI
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="odd">
                                AHI Supine
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="even">
                                RDI
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="odd">
                                RDI Supine
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="even">
                                O<sub>2</sub> Nadir
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="odd">
                                T &le; 90% O<sub>2</sub>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="even">
                                Dental Device
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="odd">
                                Device Setting
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="even">
                                Notes
                            </td>
                        </tr>
                    </table>

                    <form action="#" method="POST" style="float:left; width:185px;" enctype="multipart/form-data" onsubmit="return validate_image();">
                        <table class="sleeplabstable {{ (!empty($showYellow) && !$sleepStudy  ? 'yellow' : '') }}" id="sleepstudyscrolltable">
                            <tr>
                                <td valign="top" class="odd">
                                    <input type="text" onchange="validateDate('date');" maxlength="255" style="width: 100px;" tabindex="10" class="field text addr tbox calendar" name="date" id="date" value="{{ date('m/d/Y') }}">
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" class="even">
                                    <select name="sleeptesttype">
                                        <option value="HST Baseline">HST Baseline</option>
                                        <option value="PSG Baseline">PSG Baseline</option>
                                        <option value="HST Titration">HST Titration</option>
                                        <option value="PSG Titration">PSG Titration</option>
                                        <option value="Oximeter">Oximeter</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" class="odd">
                                    <select name="place" class="place_select" onchange="addstudylab(this.value)">
                                        <option>SELECT</option>
                                        <option value="0">Home</option>

                                        @if (!empty($sleepSlabs))
                                            @foreach ($sleepSlabs as $sleepSlab)
                                                <option value="{{ $sleepSlab->sleeplabid }}">{{ $sleepSlab->company }}</option>
                                            @endforeach
                                        @endif

                                        <option value="add">ADD SLEEP LAB</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" class="even">
                                    <select name="diagnosis" style="width:140px;" class="field text addr tbox" >
                                        <option value="">SELECT</option>

                                        @if (!empty($insDiagnoses))
                                            @foreach ($insDiagnoses as $insDiagnosis)
                                                <option value="{{ $insDiagnosis->ins_diagnosisid }}" >
                                                    {{ $insDiagnosis->ins_diagnosis }} {{ $insDiagnosis->description }}
                                                </option>
                                            @endforeach
                                        @endif

                                    </select>
                                    <span id="req_0" class="req">*</span>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" class="odd">
                                    <input style="width:100px;" type="text" id="diagnosising_doc" autocomplete="off" name="diagnosising_doc" />

                                    @if (!empty($patient->p_m_ins_type) && $patient->p_m_ins_type == 1)
                                        <span id="req_0" class="req">*</span>
                                    @endif

                                    <br />
                                    <div id="diagnosising_doc_hints" class="search_hints" style="display:none;">
                                        <ul id="diagnosising_doc_list" class="search_list">
                                            <li class="template" style="display:none">Doe, John S</li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" class="even">
                                    <input style="width:100px;" type="text" id="diagnosising_npi" name="diagnosising_npi" />

                                    @if (!empty($patient->p_m_ins_type) && $patient->p_m_ins_type == 1)
                                        <span id="req_0" class="req">*</span>
                                    @endif

                                </td>
                            </tr>
                            <tr>
                                <td valign="top" class="odd">
                                    <input style="width:140px" size="8" type="file" name="ss_file" id="ss_file" />
                                    <span id="req_0" class="req">*</span>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" class="even">
                                    <input type="text" name="ahi" />
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" class="odd">
                                    <input type="text" name="ahisupine" />
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" class="even">
                                    <input type="text" name="rdi" />
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" class="odd">
                                    <input type="text" name="rdisupine" />
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" class="even">
                                    <input type="text" name="o2nadir" />
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" class="odd">
                                    <input type="text" name="t9002" />
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" class="even" style="height:25px;">
                                    <select name="dentaldevice" style="width:150px;">
                                        <option value="">SELECT</option>

                                        @if (!empty($devices))
                                            @foreach ($devices as $device)
                                                <option value="{{ $device->deviceid }}">{{ $device->device }}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" class="odd">
                                    <input type="text" name="devicesetting" />
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" class="even">
                                    <input type="text" name="notes" />
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" class="odd">
                                    <input type="hidden" name="submitnewsleeplabsumm" value="1" />
                                    <input type="submit" value="Submit Study" />
                                </td>
                            </tr>
                        </table>
                    </form>
                </td>
            </tr>
        </table>

        @if (!empty($showBlock))
            @if (!empty($showBlock['updateProfileImage']))
                <script type="text/javascript"> 
                    parent.updateProfileImage({{ $showBlock['updateProfileImage'] }});
                </script>
            @elseif (!empty($showBlock['updateInsCard']))
                <script type="text/javascript">
                    parent.updateInsCard({{ $showBlock['updateInsCard'][0] }}, {{ $showBlock['updateInsCard'][1] }});
                </script>
            @endif

            <script type="text/javascript">
                parent.disablePopupClean();
            </script>
        @endif

    </body>
</html>
