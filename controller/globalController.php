<?php
/** Include Every Page **/

/**header and footer style sheet must move to it's controller if have multi-template in one site*/
View::addFirstSignCSS("main,header,footer,bootstrap.min,bootstrap-theme.min,style,dataTables.bootstrap.min");
View::addCSS("bootstrap-datetimepicker.min");

View::addJS("jquery-3.1.1.min,bootstrap.min,jquery.validate.min,moment.min,bootstrap-datetimepicker.min,jquery.dataTables.min,dataTables.bootstrap.min");