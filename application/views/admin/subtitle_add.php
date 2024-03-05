<?php echo form_open(base_url() . 'admin/subtitle/', array('id'  => 'subtitle_form', 'class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>

<h4 class="text-center"><?php echo trans('add_subtitle)'); ?></h4>
<hr>

<input type="hidden" name="videos_id" value="<?php echo $param2; ?>">
<input type="hidden" name="video_file_id" value="<?php echo $param3; ?>">
<div class="form-group row">
  <label class="col-sm-3 control-label"><?php echo trans('language)'); ?></label>
  <div class="col-sm-9 ">
    <select class="form-control" name="language" required>
      <option value="English">English</option>
      <option value="German">German</option>
      <option value="Bangla">Bengali/Bangla</option>
      <option value="Hindi">Hindi</option>
      <option value="Urdu">Urdu</option>
      <option value="Spanish">Spanish</option>
      <option value="French">French</option>
      <option value="Chinese">Chinese</option>
      <option value="Italian">Italian</option>
      <option value="Afar">Afar</option>
      <option value="Abkhazian">Abkhazian</option>
      <option value="Afrikaans">Afrikaans</option>
      <option value="Amharic">Amharic</option>
      <option value="Arabic">Arabic</option>
      <option value="Assamese">Assamese</option>
      <option value="Aymara">Aymara</option>
      <option value="Azerbaijani">Azerbaijani</option>
      <option value="Bashkir">Bashkir</option>
      <option value="Belarusian">Belarusian</option>
      <option value="Bulgarian">Bulgarian</option>
      <option value="Bihari">Bihari</option>
      <option value="Bislama">Bislama</option>
      <option value="Tibetan">Tibetan</option>
      <option value="Breton">Breton</option>
      <option value="Catalan">Catalan</option>
      <option value="Corsican">Corsican</option>
      <option value="Czech">Czech</option>
      <option value="Welsh">Welsh</option>
      <option value="Danish">Danish</option>
      <option value="Bhutani">Bhutani</option>
      <option value="Greek">Greek</option>
      <option value="Esperanto">Esperanto</option>
      <option value="Estonian">Estonian</option>
      <option value="Basque">Basque</option>
      <option value="Persian">Persian</option>
      <option value="Finnish">Finnish</option>
      <option value="Fiji">Fiji</option>
      <option value="Faeroese">Faeroese</option>
      <option value="Frisian">Frisian</option>
      <option value="Irish">Irish</option>
      <option value="Scots/Gaelic">Scots/Gaelic</option>
      <option value="Galician">Galician</option>
      <option value="Guarani">Guarani</option>
      <option value="Gujarati">Gujarati</option>
      <option value="Hausa">Hausa</option>
      <option value="Croatian">Croatian</option>
      <option value="Hungarian">Hungarian</option>
      <option value="Armenian">Armenian</option>
      <option value="Interlingua">Interlingua</option>
      <option value="Interlingue">Interlingue</option>
      <option value="Inupiak">Inupiak</option>
      <option value="Indonesian">Indonesian</option>
      <option value="Icelandic">Icelandic</option>
      <option value="Hebrew">Hebrew</option>
      <option value="Japanese">Japanese</option>
      <option value="Yiddish">Yiddish</option>
      <option value="Javanese">Javanese</option>
      <option value="Georgian">Georgian</option>
      <option value="Kazakh">Kazakh</option>
      <option value="Greenlandic">Greenlandic</option>
      <option value="Cambodian">Cambodian</option>
      <option value="Kannada">Kannada</option>
      <option value="Korean">Korean</option>
      <option value="Kashmiri">Kashmiri</option>
      <option value="Kurdish">Kurdish</option>
      <option value="Kirghiz">Kirghiz</option>
      <option value="Latin">Latin</option>
      <option value="Lingala">Lingala</option>
      <option value="Laothian">Laothian</option>
      <option value="Lithuanian">Lithuanian</option>
      <option value="Latvian/Lettish">Latvian/Lettish</option>
      <option value="Malagasy">Malagasy</option>
      <option value="Maori">Maori</option>
      <option value="Macedonian">Macedonian</option>
      <option value="Malayalam">Malayalam</option>
      <option value="Mongolian">Mongolian</option>
      <option value="Moldavian">Moldavian</option>
      <option value="Marathi">Marathi</option>
      <option value="Malay">Malay</option>
      <option value="Maltese">Maltese</option>
      <option value="Burmese">Burmese</option>
      <option value="Nauru">Nauru</option>
      <option value="Nepali">Nepali</option>
      <option value="Dutch">Dutch</option>
      <option value="Norwegian">Norwegian</option>
      <option value="Occitan">Occitan</option>
      <option value="(Afan)/Oromoor/Oriya">(Afan)/Oromoor/Oriya</option>
      <option value="Punjabi">Punjabi</option>
      <option value="Polish">Polish</option>
      <option value="Pashto/Pushto">Pashto/Pushto</option>
      <option value="Portuguese">Portuguese</option>
      <option value="Quechua">Quechua</option>
      <option value="Rhaeto-Romance">Rhaeto-Romance</option>
      <option value="Kirundi">Kirundi</option>
      <option value="Romanian">Romanian</option>
      <option value="Russian">Russian</option>
      <option value="Kinyarwanda">Kinyarwanda</option>
      <option value="Sanskrit">Sanskrit</option>
      <option value="Sindhi">Sindhi</option>
      <option value="Sangro">Sangro</option>
      <option value="Serbo-Croatian">Serbo-Croatian</option>
      <option value="Singhalese">Singhalese</option>
      <option value="Slovak">Slovak</option>
      <option value="Slovenian">Slovenian</option>
      <option value="Samoan">Samoan</option>
      <option value="Shona">Shona</option>
      <option value="Somali">Somali</option>
      <option value="Albanian">Albanian</option>
      <option value="Serbian">Serbian</option>
      <option value="Siswati">Siswati</option>
      <option value="Sesotho">Sesotho</option>
      <option value="Sundanese">Sundanese</option>
      <option value="Swedish">Swedish</option>
      <option value="Swahili">Swahili</option>
      <option value="Tamil">Tamil</option>
      <option value="Telugu">Telugu</option>
      <option value="Tajik">Tajik</option>
      <option value="Thai">Thai</option>
      <option value="Tigrinya">Tigrinya</option>
      <option value="Turkmen">Turkmen</option>
      <option value="Tagalog">Tagalog</option>
      <option value="Setswana">Setswana</option>
      <option value="Tonga">Tonga</option>
      <option value="Turkish">Turkish</option>
      <option value="Tsonga">Tsonga</option>
      <option value="Tatar">Tatar</option>
      <option value="Twi">Twi</option>
      <option value="Ukrainian">Ukrainian</option>
      <option value="Uzbek">Uzbek</option>
      <option value="Vietnamese">Vietnamese</option>
      <option value="Volapuk">Volapuk</option>
      <option value="Wolof">Wolof</option>
      <option value="Xhosa">Xhosa</option>
      <option value="Yoruba">Yoruba</option>
      <option value="Zulu">Zulu</option>
    </select>
  </div>
  <!-- End col-6 -->
</div>
<!-- end form -group -->

<div class="form-group row">
  <label class="col-sm-3 control-label"><?php echo trans('kind)'); ?></label>
  <div class="col-sm-9 ">
    <select class="form-control" name="kind" required>
      <option value="captions"><?php echo trans('captions)'); ?></option>
      <option value="subtitles"><?php echo trans('subtitles)'); ?></option>
    </select>
  </div>
  <!-- End col-6 -->
</div>
<!-- end form -group -->

<div class="form-group row">
  <label class="col-sm-3 control-label"><?php echo trans('upload_vtt_file)'); ?></label>
  <div class="col-sm-9 ">
    <input type="file" id="" name="vtt_file" class="filestyle" data-input="false">
  </div>
</div>

<div class="form-group row">
  <label class="col-sm-3 control-label"><?php echo trans('or_vtt_from_url)'); ?></label>
  <div class="col-sm-9 ">
    <input type="text" id="" name="vtt_url" class="form-control">
  </div>
</div>
<div class="form-group row">
  <label class="col-sm-3 control-label"></label>
  <div class="col-sm-9 ">
    <p><?php echo trans('note)'); ?>:<?php echo trans('only_vtt_is_supported_note)'); ?> <a href="https://atelier.u-sub.net/srt2vtt/" target="_blank"><?php echo trans('here)'); ?></a></p>
  </div>
</div>


<div class="form-group row">
  <div class="col-sm-offset-3 col-sm-6 m-t-15">
    <button type="submit" class="btn btn-sm btn-primary waves-effect"> <span class="btn-label"><i class="fa fa-plus"></i></span><?php echo trans('add)'); ?></button>
    <button type="" class="btn btn-sm btn-white m-l-5 waves-effect" data-dismiss="modal"><?php echo trans('close)'); ?> </button>
  </div>
  <!-- End col-6 -->
</div>
<!-- end form -group -->
<?php echo form_close(); ?>

<script>
  $(document).ready(function() {
    $('form').parsley();
    $(".select2").select2();
  });
</script>