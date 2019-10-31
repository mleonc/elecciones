<div class="ue-l-common-page__box js-ueTopBars">
<?php if (($type == 'autonomicas-localidades') || ($type == 'municipales')): ?>
    <div class="ue-l-common-page__row ue-l-common-page__row--no-gutter">
        <div class="ue-c-elections-simple-widget">
            <h2 class="ue-c-elections-simple-widget__title">Total <?php echo $name; ?></h3>
            <div class="ue-c-elections-result-bars ">
                <div class="ue-c-elections-result-bars__bar">
                    <div class="ue-c-elections-result-bars__bar-party">ND</div>
                    <div class="ue-c-elections-result-bars__bar-base">
                        <div class="ue-c-elections-result-bars__bar-over" style="width: 0.0% ; background: #333333;"></div>
                    </div>
                    <div class="ue-c-elections-result-bars__bar-percent">0%</div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if ($type == 'autonomicas-localidades' || ($type == 'autonomicas' && $code != '99') || ($type == 'municipales')): ?>
    <div class="ue-l-common-page__row">
        <div class="ue-l-common-page__column ue-l-common-page--size6of12">
            <div class="ue-c-elections-simple-widget">
                <h2 class="ue-c-elections-simple-widget__title">Total Provincia de <?php echo iconv("UTF-8", "ISO-8859-1//IGNORE", $ccaa['lista_circunscripciones'][$elementCode]['name']); ?></h3>
                <div class="ue-c-elections-result-bars ">
                    <div class="ue-c-elections-result-bars__bar">
                        <div class="ue-c-elections-result-bars__bar-party">ND</div>
                        <div class="ue-c-elections-result-bars__bar-base">
                            <div class="ue-c-elections-result-bars__bar-over" style="width: 0.0% ; background: #333333;"></div>
                        </div>
                        <div class="ue-c-elections-result-bars__bar-percent">0%</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ue-l-common-page__column ue-l-common-page--size6of12">
            <div class="ue-c-elections-simple-widget">
                <h2 class="ue-c-elections-simple-widget__title">Total <?php echo $ccaa['name']; ?></h3>
                <div class="ue-c-elections-result-bars ">
                    <div class="ue-c-elections-result-bars__bar">
                        <div class="ue-c-elections-result-bars__bar-party">ND</div>
                        <div class="ue-c-elections-result-bars__bar-base">
                            <div class="ue-c-elections-result-bars__bar-over" style="width: 0.0%; background-color: #333333;"></div>
                        </div>
                        <div class="ue-c-elections-result-bars__bar-percent">0%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if ($type == 'autonomicas' && $code == '99'): ?>
    <div class="ue-l-common-page__row ue-l-common-page__row--no-gutter">
        <div class="ue-c-elections-simple-widget">
            <h2 class="ue-c-elections-simple-widget__title">Total <?php echo $ccaa['name']; ?></h3>
            <div class="ue-c-elections-result-bars ">
                <div class="ue-c-elections-result-bars__bar">
                    <div class="ue-c-elections-result-bars__bar-party">ND</div>
                    <div class="ue-c-elections-result-bars__bar-base">
                        <div class="ue-c-elections-result-bars__bar-over" style="width: 0.0% ; background: #333333;"></div>
                    </div>
                    <div class="ue-c-elections-result-bars__bar-percent">0%</div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
</div>