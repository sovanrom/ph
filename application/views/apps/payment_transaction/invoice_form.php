<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php 
    $arrStart = explode('-',$result->start_billing_date);
    $arrEnd = explode('-',$result->end_billing_date);
 ?>
    <div style="width:95%; margin-left:20px; margin-right:10px;">
        <table border="0" width="100%">
            <tbody><tr>
                <td width="53%" align="left">
                    <h5>សម្រាប់ខែ  .... <?php echo $arrStart[1]?> .... ឆ្នាំ <?php echo $arrStart[0]?> </h5>
                </td>  
                <td width="34%" align="right">
                    <h5>បន្ទប់លេខ :</h5>
                </td>
                <td width="13%">
                    <h4>&nbsp; <?php echo $result->room_name?></h4>
                </td>
            </tr>
            <tr>
                <td align="center" colspan="3">
                    <u><h4>បង្កាន់ដៃទទួលប្រាក់</h4></u>
                </td>
            </tr>
        </tbody>
        </table>
        <table border="0" width="100%">
            <tbody>
                <tr>
                    <td align="left"><h5>ទទួលបានពីឈ្មោះ ..... <?php echo $result->staying_name?> ......</h5></td>
                    <td align="left">
                        <h5>ភេទ ... <?php echo $result->name?> ...</h5>
                    </td>
                </tr>
               <tr>
                    <td align="left" valign="top" colspan="2">
                       <h5>ស្នាក់នៅពីថ្ងៃទី ... <?php echo $arrStart[2]?> ... ខែ ... <?php echo $arrStart[1]?> ... ឆ្នាំ <?php echo $arrStart[0]?> ... <span class="pull-right">ដល់ថ្ងៃទី ... <?php echo $arrEnd[2]?> ... ខែ ... <?php echo $arrEnd[1]?> ... ឆ្នាំ <?php echo $arrEnd[0]?> .............</span></h5>
                    </td> 
                </tr> 
                <tr>
                    <td align="left" valign="top" colspan="2">
                       <h5>មុខរបរជា ...... <?php echo $result->job?> ........ <span class="pull-right">ចំនួនទឹកប្រាក់ដែលត្រូវបង់: ... <?php echo $result->room_amount?> USD ....... ។</span></h5>
                       <h5>* សម្គាល់ សូមបង់ប្រាក់នៅរៀងរាល់ដើមខែនីមួយៗ ។        </h5>
                    </td>
                </tr>
            </tbody>
        </table>
        <center>
        <table border="0" width="85%">
            <tbody><tr>
                <td width="28%" align="center">
                    <h5>អ្នកទទួល</h5>
                    <h5>ហត្ថលេខា និងឈ្មោះ</h5>
                    <br />
                    <h5><?php echo $this->session->userdata('FULL_NAME_KH');?></h5>
                </td>
                <td width="40%" align="left">&nbsp;  </td>
                <td width="32%" align="center">
                    <h5>អ្នកបង់ប្រាក់</h5>
                    <h5>ហត្ថលេខា និងឈ្មោះ</h5>
                </td>
            </tr></tbody>
        </table>
        </center>
        <br />
        <hr>
        <br>
        <table border="0" width="100%">
            <tbody>
            <tr>
                <td align="center" colspan="2">
                    <u><h4>វិក្កយបត្រភ្លើង</h4></u>
                </td>
            </tr>
            </tbody>
        </table>
        <table border="0" width="100%">
            <tbody>
                <tr>
                    <td width="50%" align="left"><h5>លេខអំណានចាស់....... <?php echo $result->water_old?> .......</h5></td>
                    <td width="50%" align="left">
                        <h5>កាលបរិចេ្ចទ....... <?php echo $result->start_billing_date?> .......</h5>
                    </td>
                </tr> ​
                <tr>
                    <td align="left"><h5>លេខអំណានថ្មី............ <?php echo $result->water_new?> .......</h5></td>
                    <td align="left">
                        <h5>កាលបរិចេ្ចទ........ <?php echo $result->invoice_date?> .......</h5>
                    </td>
                </tr> ​
                <tr>
                    <td align="left"><h5>បរិមាណភ្លើងប្រើប្រាស់....... <?php echo $result->water_usage?> .......</h5></td>
                    <td align="left">
                        <h5>Kw x <?php echo $result->water_price?>៛ = ....... <?php echo $result->total_water_price?> .......</h5>
                    </td>
                </tr>
            </tbody>
        </table>
         <table border="0" width="100%">
            <tbody>
            <tr>
                <td align="center" colspan="2">
                    <u><h4>វិក្កយបត្រទឹក</h4></u>
                </td>
            </tr>
            </tbody>
        </table>
        <table border="0" width="100%">
            <tbody>
                <tr>
                    <td width="50%" align="left"><h5>លេខអំណានចាស់....... <?php echo $result->elect_old?> .......</h5></td>
                    <td width="50%" align="left">
                        <h5>កាលបរិចេ្ចទ....... <?php echo $result->start_billing_date?> .......</h5>
                    </td>
                </tr> ​
                <tr>
                    <td align="left"><h5>លេខអំណានថ្មី............ <?php echo $result->elect_new?> .......</h5></td>
                    <td align="left">
                        <h5>កាលបរិចេ្ចទ........ <?php echo $result->invoice_date?> .......</h5>
                    </td>
                </tr> ​
                <tr>
                    <td align="left"><h5>បរិមាណភ្លើងប្រើប្រាស់....... <?php echo $result->elect_usage?> .......</h5></td>
                    <td align="left">
                        <h5>Kw x <?php echo $result->elect_price?>៛ = ....... <?php echo $result->total_elect_price?> .......</h5>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <hr>

    