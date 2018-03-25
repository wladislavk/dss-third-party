<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">

        {!! HTML::style('/css/manage/admin.css') !!}
        {!! HTML::style('/css/manage/form.css') !!}

        {!! HTML::script('/js/jquery-1.6.2.min.js') !!}
        {!! HTML::script('/js/3rdParty/jquery.maskedinput-1.3.min.js') !!}
        {!! HTML::script('/js/manage/validation.js') !!}
        {!! HTML::script('/js/manage/masks.js') !!}
        {!! HTML::script('/js/manage/wufoo.js') !!}
        {!! HTML::script('/js/manage/preferred_contact.js') !!}
        {!! HTML::script('/js/manage/contact.js') !!}
        {!! HTML::script('/js/manage/add_ticket.js') !!}
    </head>
    <body>
        <br /><br />

        @if (!empty($alert))
            <script>
                alert('{{ $alert }}');
            </script>
        @endif

        @if (!empty($redirect))
            <script>
                parent.window.location = '/manage/support';
            </script>
        @endif

        <form name="contactfrm" action="/manage/add_ticket" method="post" style="width:99%;" enctype="multipart/form-data" onsubmit="return ticketabc(this)">
            <table width="99%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" style="margin-left: 11px;">
                <tr>
                    <td colspan="2" class="cat_head">
                        Add Support Ticket
                    </td>
                </tr>
                <tr>
                    <td valign="top" colspan="2" class="frmhead">
                        <ul>
                            <li id="foli8" class="complex">
                                <div>
                                    <span>
                                        <select id="category_id" name="category_id" class="field text addr tbox">
                                            <option value="">Select a category</option>

                                            @if (count($nonActiveCategories))
                                                @foreach ($nonActiveCategories as $nonActiveCategory)
                                                    <option {{ ($categoryId == $nonActiveCategory->id) ? "selected='selected'" : "" }} value="{{ $nonActiveCategory->id or '' }}">
                                                        {{ $nonActiveCategory->title }}
                                                    </option>
                                                @endforeach
                                            @endif

                                        </select>
                                        <label for="contacttype">Category</label>
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td valign="top" colspan="2" class="frmhead">
                        <ul>
                            <li id="foli8" class="complex">
                                <div>
                                    <span>
                                        <select id="company_id" name="company_id" class="field text addr tbox">
                                            <option value="0">Dental Sleep Solutions</option>

                                            @if (count($billingCompanies))
                                                @foreach ($billingCompanies as $billingCompany)
                                                    <option {{ ($companyId == $billingCompany->id) ? "selected='selected'" : "" }} value="{{ $billingCompany->id or '' }}">
                                                        {{ $billingCompany->name }}
                                                    </option>
                                                @endforeach
                                            @endif

                                        </select>
                                        <label for="contacttype">Send To</label>
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </td>
                </tr>
                <tr class="content">
                    <td valign="top" colspan="2" class="frmhead">
                        <ul>
                            <li id="foli8" class="complex"> 
                                <div>
                                    <span>
                                        <input id="title" name="title" type="text" class="field text addr tbox" value="{{ $title }}" tabindex="2" maxlength="255" />
                                        <label for="firstname">Title</label>
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </td>
                </tr>
                <tr class="content physician insurance other"> 
                    <td valign="top" colspan="2" class="frmhead">
                        <ul>
                            <li id="foli8" class="complex"> 
                                <label class="desc" id="title0" for="Field0">
                                    Message:
                                </label>
                                <div>
                                    <span class="full">
                                        <textarea name="body" id="body" class="field text addr tbox" tabindex="21" style="width:600px; height:150px;">{{ $body }}</textarea>
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </td>
                </tr>
                <tr class="content physician insurance other">
                    <td valign="top" colspan="2" class="frmhead">
                        <ul>
                            <li id="foli8" class="complex">
                                <label class="desc" id="title0" for="Field0">
                                    Attachment:
                                </label>
                                <div>
                                    <span class="full">
                                        <div id="attachments">
                                            <span class="fullwidth">
                                                <input type="file" name="attachment[]" id="attachment1" class="attachment field text addr tbox" onchange="$('#add_attachment_but').show();" style="width:auto;" />
                                                <a href="#" onclick="$(this).parent().remove();$('#add_attachment_but').show();return false;">Remove</a>
                                            </span>
                                        </div>
                                        <a href="#" id="add_attachment_but" onclick="add_attachment();return false;" style="display:none;" class="button">Add Additional</a>
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </td>
                </tr>
                <tr class="content physician insurance other">
                    <td  colspan="2" align="center">
                        <span class="red">
                            * Required Fields
                        </span><br />
                        <input type="hidden" name="ticketsub" value="1" />
                        <input type="submit" value=" {{ $buttonText }} Ticket" class="button" />
                    </td>
                </tr>
            </table>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    </body>
</html>
