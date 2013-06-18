var FormComponents = function () {

    var handleWysihtml5 = function () {
        if (!jQuery().wysihtml5) {
            return;
        }

        if ($('.wysihtml5').size() > 0) {
            $('.wysihtml5').wysihtml5();
        }
    }

    var handleToggleButtons = function () {
        if (!jQuery().toggleButtons) {
            return;
        }
        $('.basic-toggle-button').toggleButtons();
        $('.text-toggle-button').toggleButtons({
            width: 200,
            label: {
                enabled: "Lorem Ipsum",
                disabled: "Dolor Sit"
            }
        });
        $('.danger-toggle-button').toggleButtons({
            style: {
                // Accepted values ["primary", "danger", "info", "success", "warning"] or nothing
                enabled: "danger",
                disabled: "info"
            }
        });
        $('.info-toggle-button').toggleButtons({
            style: {
                enabled: "info",
                disabled: ""
            }
        });
        $('.success-toggle-button').toggleButtons({
            style: {
                enabled: "success",
                disabled: "info"
            }
        });
        $('.warning-toggle-button').toggleButtons({
            style: {
                enabled: "warning",
                disabled: "info"
            }
        });

        $('.height-toggle-button').toggleButtons({
            height: 100,
            font: {
                'line-height': '100px',
                'font-size': '20px',
                'font-style': 'italic'
            }
        });
    }

    var handleTagsInput = function () {
        if (!jQuery().tagsInput) {
            return;
        }
        $('#tags_1').tagsInput({
            width: 'auto',
            'onAddTag': function () {
                //alert(1);
            },
        });
        $('#tags_2').tagsInput({
            width: 240
        });
    }

    var handlejQueryUIDatePickers = function () {
        $( ".ui-date-picker" ).datepicker();
    }

    var handleDateTimePickers = function () {

        if (jQuery().datepicker) {
            $('.date-picker').datepicker();
            console.log('bla');
        }

        if (jQuery().timepicker) {
            $('.timepicker-default').timepicker();
            $('.timepicker-24').timepicker({
                minuteStep: 1,
                showSeconds: true,
                showMeridian: false
            });
        }

        if (!jQuery().daterangepicker) {
            return;
        }

        $('.date-range').daterangepicker(
            {
                opens: (App.isRTL() ? 'left' : 'right'),
                format: 'MM/dd/yyyy',
                separator: ' to ',
                startDate: Date.today().add({
                    days: -29
                }),
                endDate: Date.today(),
                minDate: '01/01/2012',
                maxDate: '12/31/2014',
            }
        );

        $('#form-date-range').daterangepicker({
            ranges: {
                'Today': ['today', 'today'],
                'Yesterday': ['yesterday', 'yesterday'],
                'Last 7 Days': [Date.today().add({
                        days: -6
                    }), 'today'],
                'Last 29 Days': [Date.today().add({
                        days: -29
                    }), 'today'],
                'This Month': [Date.today().moveToFirstDayOfMonth(), Date.today().moveToLastDayOfMonth()],
                'Last Month': [Date.today().moveToFirstDayOfMonth().add({
                        months: -1
                    }), Date.today().moveToFirstDayOfMonth().add({
                        days: -1
                    })]
            },
            opens: (App.isRTL() ? 'left' : 'right'),
            format: 'MM/dd/yyyy',
            separator: ' to ',
            startDate: Date.today().add({
                days: -29
            }),
            endDate: Date.today(),
            minDate: '01/01/2012',
            maxDate: '12/31/2014',
            locale: {
                applyLabel: 'Submit',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom Range',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            },
            showWeekNumbers: true,
            buttonClasses: ['btn-danger']
        },

        function (start, end) {
            $('#form-date-range span').html(start.toString('MMMM d, yyyy') + ' - ' + end.toString('MMMM d, yyyy'));
        });

        $('#form-date-range span').html(Date.today().add({
            days: -29
        }).toString('MMMM d, yyyy') + ' - ' + Date.today().toString('MMMM d, yyyy'));


        if (!jQuery().datepicker || !jQuery().timepicker) {
            return;
        }
    }

    var handleNewDatetimePicker = function () {        

          $(".form_datetime").datetimepicker({
              format: "dd MM yyyy - hh:ii",
              pickerPosition: "bottom-left"
          });

         $(".form_advance_datetime").datetimepicker({
              format: "dd MM yyyy - hh:ii",
              autoclose: true,
              todayBtn: true,
              startDate: "2013-02-14 10:00",
              pickerPosition: "bottom-left",
              minuteStep: 10
          });

         $(".form_meridian_datetime").datetimepicker({
            format: "dd MM yyyy - HH:ii P",
            showMeridian: true,
            autoclose: true,
            pickerPosition: "bottom-left",
            todayBtn: true
        });
    }

    var handleClockfaceTimePickers = function () {

        if (!jQuery().clockface) {
            return;
        }

        $('#clockface_1').clockface();

        $('#clockface_2').clockface({
            format: 'HH:mm',
            trigger: 'manual'
        });

        $('#clockface_2_toggle-btn').click(function (e) {
            e.stopPropagation();
            $('#clockface_2').clockface('toggle');
        });

        $('#clockface_3').clockface({
            format: 'H:mm'
        }).clockface('show', '14:30');
    }

    var handleColorPicker = function () {
        if (!jQuery().colorpicker) {
            return;
        }
        $('.colorpicker-default').colorpicker({
            format: 'hex'
        });
        $('.colorpicker-rgba').colorpicker();
    }

    

    

    return {
        //main function to initiate the module
        init: function () {
            handleWysihtml5();
            handleToggleButtons();
            handleTagsInput();
            handlejQueryUIDatePickers();
            handleDateTimePickers();
            handleNewDatetimePicker();
            handleClockfaceTimePickers();
            handleColorPicker();
        }

    };

}();