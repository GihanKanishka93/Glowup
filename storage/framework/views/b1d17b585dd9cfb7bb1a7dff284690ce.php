<?php $__env->startSection('content'); ?>
    <?php
        $averageBill = $billCount > 0 ? $billSum / $billCount : 0;
        $reportCharts = [
            'daily' => $dailyBreakdown ?? [],
            'doctors' => $doctorBreakdown ?? [],
        ];
    ?>
    <?php if (isset($component)) { $__componentOriginal7bc554465605ca2958f2d0eb6e9a7ddd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7bc554465605ca2958f2d0eb6e9a7ddd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.list-page','data' => ['title' => 'Billing Report','backRoute' => url()->previous(),'subtitle' => 'From ' . $startDate . ' to ' . $endDate,'class' => 'reports-monthly']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('list-page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Billing Report','back-route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(url()->previous()),'subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('From ' . $startDate . ' to ' . $endDate),'class' => 'reports-monthly']); ?>
        <div class="report-shell">
            <div class="report-filters">
                <form id="dateRangeForm" action="<?php echo e(route('report.monthly-report')); ?>" method="get" class="row g-3">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('GET'); ?>
                    <div class="col-12">
                        <div class="filter-heading">
                            <div>
                                <h6 class="mb-1">Filter by Date & Team</h6>
                                <p class="text-muted mb-0">Refine the report without leaving the page.</p>
                            </div>
                            <div class="filter-actions">
                                <button type="submit" class="btn btn-primary" id="filterBtn">
                                    <i class="fas fa-filter me-1"></i>Apply
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="clearBtn">
                                    <i class="fas fa-undo me-1"></i>Clear
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="text" id="start_date" name="start_date" class="datepicker form-control"
                            value="<?php echo e(old('start_date', $startDate)); ?>" placeholder="YYYY-MM-DD">
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="text" id="end_date" name="end_date" class="datepicker form-control"
                            value="<?php echo e(old('end_date', $endDate)); ?>" placeholder="YYYY-MM-DD">
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <label for="doctor_id" class="form-label">Doctor</label>
                        <select id="doctor_id" name="doctor_id" class="form-select select2" data-placeholder="Any Doctor">
                            <option value=""></option>
                            <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($doctor->id); ?>" <?php if(old('doctor_id', $selectedDoctorId ?? null) == $doctor->id): echo 'selected'; endif; ?>>
                                    <?php echo e($doctor->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <label for="patient_id" class="form-label">Client</label>
                        <select id="patient_id" name="patient_id" class="form-select select2" data-placeholder="Any Client">
                            <option value=""></option>
                            <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($patient->id); ?>" <?php if(old('patient_id', $selectedPatientId ?? null) == $patient->id): echo 'selected'; endif; ?>>
                                    <?php echo e($patient->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </form>
            </div>

            <div class="row row-cols-1 row-cols-md-3 g-3 report-metrics">
                <div class="col">
                    <div class="report-metric-card">
                        <div class="metric-icon">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <div class="metric-copy">
                            <span class="metric-label">Number of Bills</span>
                            <span class="metric-value" id="billCount"><?php echo e(number_format($billCount)); ?></span>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="report-metric-card">
                        <div class="metric-icon metric-icon-success">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="metric-copy">
                            <span class="metric-label">Total Billing Amount</span>
                            <span class="metric-value" id="billSum"><?php echo e(number_format($billSum, 2, '.', ',')); ?></span>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="report-metric-card">
                        <div class="metric-icon metric-icon-muted">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="metric-copy">
                            <span class="metric-label">Average Per Bill</span>
                            <span class="metric-value" id="billAverage"><?php echo e(number_format($averageBill, 2, '.', ',')); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="report-visuals row g-3 align-items-stretch">
                <div class="col-12 col-xl-7">
                    <div class="report-chart-card h-100">
                        <div class="chart-header">
                            <div>
                                <h6 class="mb-0">Revenue Trend</h6>
                                <span>Daily totals across the selected range</span>
                            </div>
                        </div>
                        <div class="chart-body">
                            <canvas id="billingTrendChart" aria-label="Daily revenue trend" role="img"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-5">
                    <div class="report-chart-card h-100">
                        <div class="chart-header">
                            <div>
                                <h6 class="mb-0">Revenue by Doctor</h6>
                                <span>Top performers by collected total</span>
                            </div>
                        </div>
                        <div class="chart-body">
                            <canvas id="doctorShareChart" aria-label="Revenue by doctor" role="img"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="report-table-wrapper">
                <?php echo $dataTable->table(['class' => 'table table-hover align-middle w-100']); ?>

            </div>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7bc554465605ca2958f2d0eb6e9a7ddd)): ?>
<?php $attributes = $__attributesOriginal7bc554465605ca2958f2d0eb6e9a7ddd; ?>
<?php unset($__attributesOriginal7bc554465605ca2958f2d0eb6e9a7ddd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7bc554465605ca2958f2d0eb6e9a7ddd)): ?>
<?php $component = $__componentOriginal7bc554465605ca2958f2d0eb6e9a7ddd; ?>
<?php unset($__componentOriginal7bc554465605ca2958f2d0eb6e9a7ddd); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('third_party_stylesheets'); ?>
    <link href="<?php echo e(asset('plugin/datatable/jquery.dataTables.min.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('plugin/datatable/dataTables.bootstrap4.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('plugin/select2/select2.min.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('third_party_scripts'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.js"></script>
    <script src="<?php echo e(asset('plugin/select2/select2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugin/datatable/jquery.dataTables.min.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <?php echo $dataTable->scripts(); ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        const reportChartInitialData = <?php echo json_encode($reportCharts, 15, 512) ?>;
        const reportChartStaticColors = ['#4f46e5', '#22c55e', '#f59e0b', '#38bdf8', '#ec4899', '#a855f7', '#f97316', '#0ea5e9', '#10b981', '#fb7185'];
        let billingTrendChart = null;
        let doctorShareChart = null;

        const colorWithAlpha = (color, alpha) => {
            const value = (color || '').trim();
            if (!value) {
                return `rgba(79, 70, 229, ${alpha})`;
            }
            if (value.startsWith('#')) {
                let hex = value.replace('#', '');
                if (hex.length === 3) {
                    hex = hex.split('').map(char => char + char).join('');
                }
                const intVal = parseInt(hex, 16);
                const r = (intVal >> 16) & 255;
                const g = (intVal >> 8) & 255;
                const b = intVal & 255;
                return `rgba(${r}, ${g}, ${b}, ${alpha})`;
            }
            if (value.startsWith('rgb')) {
                const parts = value.replace(/rgba?\(|\)|\s/g, '').split(',').map(Number);
                const [r = 79, g = 70, b = 229] = parts;
                return `rgba(${r}, ${g}, ${b}, ${alpha})`;
            }
            return value;
        };

        const getChartPalette = () => {
            const styles = getComputedStyle(document.body);
            const primary = styles.getPropertyValue('--primary').trim() || '#4f46e5';
            const accent = styles.getPropertyValue('--accent').trim() || '#22c55e';
            const text = styles.getPropertyValue('--text-primary').trim() || '#111827';
            const muted = styles.getPropertyValue('--text-muted').trim() || '#64748b';
            const border = styles.getPropertyValue('--border').trim() || 'rgba(148,163,184,0.4)';
            const surface = styles.getPropertyValue('--surface').trim() || '#ffffff';
            return { primary, accent, text, muted, border, surface };
        };

        const normalizeDailyDataset = (daily = []) => {
            if (!Array.isArray(daily) || !daily.length) {
                return {
                    labels: ['No data'],
                    revenue: [0],
                    counts: [0],
                };
            }
            return {
                labels: daily.map(item => item.label || item.day),
                revenue: daily.map(item => Number(item.total || 0)),
                counts: daily.map(item => Number(item.count || 0)),
            };
        };

        const normalizeDoctorDataset = (doctors = []) => {
            if (!Array.isArray(doctors) || !doctors.length) {
                return {
                    labels: ['No data'],
                    totals: [0],
                };
            }
            return {
                labels: doctors.map(item => item.name || 'Unknown'),
                totals: doctors.map(item => Number(item.total || 0)),
            };
        };

        const initializeReportCharts = (data) => {
            const palette = getChartPalette();
            const daily = normalizeDailyDataset(data.daily);
            const doctor = normalizeDoctorDataset(data.doctors);

            const trendCtx = document.getElementById('billingTrendChart');
            const doctorCtx = document.getElementById('doctorShareChart');

            if (trendCtx) {
                billingTrendChart = new Chart(trendCtx, {
                    type: 'bar',
                    data: {
                        labels: daily.labels,
                        datasets: [
                            {
                                type: 'line',
                                label: 'Revenue',
                                data: daily.revenue,
                                yAxisID: 'yRevenue',
                                borderColor: palette.primary,
                                backgroundColor: colorWithAlpha(palette.primary, 0.25),
                                borderWidth: 2,
                                tension: 0.35,
                                fill: true,
                                pointRadius: 3,
                                pointBackgroundColor: palette.primary,
                                pointBorderColor: palette.surface,
                            },
                            {
                                type: 'bar',
                                label: 'Bills',
                                data: daily.counts,
                                yAxisID: 'yBills',
                                backgroundColor: colorWithAlpha(palette.accent, 0.6),
                                borderRadius: 6,
                                maxBarThickness: 26,
                            },
                        ],
                    },
                    options: {
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                labels: {
                                    color: palette.text,
                                    usePointStyle: true,
                                },
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                callbacks: {
                                    label: function(context) {
                                        const value = context.parsed.y ?? 0;
                                        if (context.dataset.yAxisID === 'yRevenue') {
                                            return `${context.dataset.label}: ${value.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                                        }
                                        return `${context.dataset.label}: ${value.toLocaleString()}`;
                                    },
                                },
                            },
                        },
                        scales: {
                            x: {
                                grid: {
                                    color: colorWithAlpha(palette.border, 0.35),
                                },
                                ticks: {
                                    color: palette.muted,
                                },
                            },
                            yRevenue: {
                                type: 'linear',
                                position: 'left',
                                grid: {
                                    color: colorWithAlpha(palette.border, 0.35),
                                },
                                ticks: {
                                    color: palette.muted,
                                    callback: (value) => value.toLocaleString(),
                                },
                            },
                            yBills: {
                                type: 'linear',
                                position: 'right',
                                grid: {
                                    drawOnChartArea: false,
                                },
                                ticks: {
                                    color: palette.muted,
                                    callback: (value) => value.toLocaleString(),
                                },
                            },
                        },
                    },
                });
            }

            if (doctorCtx) {
                const colors = doctor.labels.map((_, index) => reportChartStaticColors[index % reportChartStaticColors.length]);
                doctorShareChart = new Chart(doctorCtx, {
                    type: 'doughnut',
                    data: {
                        labels: doctor.labels,
                        datasets: [
                            {
                                label: 'Revenue',
                                data: doctor.totals,
                                backgroundColor: colors,
                                borderColor: palette.surface,
                                borderWidth: 2,
                                hoverOffset: 6,
                            },
                        ],
                    },
                    options: {
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: palette.text,
                                    usePointStyle: true,
                                },
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const value = context.parsed ?? 0;
                                        return `${context.label}: ${value.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                                    },
                                },
                            },
                        },
                    },
                });
            }
        };

        const updateReportCharts = (data) => {
            if (!billingTrendChart || !doctorShareChart) {
                initializeReportCharts(data);
                return;
            }

            const palette = getChartPalette();
            const daily = normalizeDailyDataset(data.daily);
            const doctor = normalizeDoctorDataset(data.doctors);

            billingTrendChart.data.labels = daily.labels;
            billingTrendChart.data.datasets[0].data = daily.revenue;
            billingTrendChart.data.datasets[0].borderColor = palette.primary;
            billingTrendChart.data.datasets[0].backgroundColor = colorWithAlpha(palette.primary, 0.25);
            billingTrendChart.data.datasets[0].pointBackgroundColor = palette.primary;
            billingTrendChart.data.datasets[0].pointBorderColor = palette.surface;
            billingTrendChart.data.datasets[1].data = daily.counts;
            billingTrendChart.data.datasets[1].backgroundColor = colorWithAlpha(palette.accent, 0.6);
            billingTrendChart.options.scales.x.ticks.color = palette.muted;
            billingTrendChart.options.scales.x.grid.color = colorWithAlpha(palette.border, 0.35);
            billingTrendChart.options.scales.yRevenue.ticks.color = palette.muted;
            billingTrendChart.options.scales.yRevenue.grid.color = colorWithAlpha(palette.border, 0.35);
            billingTrendChart.options.scales.yBills.ticks.color = palette.muted;
            billingTrendChart.options.plugins.legend.labels.color = palette.text;
            billingTrendChart.update();

            const colors = doctor.labels.map((_, index) => reportChartStaticColors[index % reportChartStaticColors.length]);
            doctorShareChart.data.labels = doctor.labels;
            doctorShareChart.data.datasets[0].data = doctor.totals;
            doctorShareChart.data.datasets[0].backgroundColor = colors;
            doctorShareChart.data.datasets[0].borderColor = palette.surface;
            doctorShareChart.options.plugins.legend.labels.color = palette.text;
            doctorShareChart.update();
        };

        const observeThemeChanges = () => {
            const body = document.body;
            if (!body) {
                return;
            }
            const observer = new MutationObserver(() => {
                if (!billingTrendChart || !doctorShareChart) {
                    return;
                }
                updateReportCharts({
                    daily: billingTrendChart.data.labels.map((label, index) => ({
                        label,
                        total: billingTrendChart.data.datasets[0].data[index],
                        count: billingTrendChart.data.datasets[1].data[index],
                    })),
                    doctors: doctorShareChart.data.labels.map((label, index) => ({
                        name: label,
                        total: doctorShareChart.data.datasets[0].data[index],
                    })),
                });
            });
            observer.observe(body, { attributes: true, attributeFilter: ['class'] });
        };
    </script>

    <script>
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
        });

        $(function() {
            const form = $('#dateRangeForm');
            const selectElements = form.find('.select2');

            initializeReportCharts(reportChartInitialData);
            observeThemeChanges();

            selectElements.select2({
                placeholder: function() {
                    return $(this).data('placeholder');
                },
                allowClear: true,
                width: '100%'
            });

            const billingTable = window.LaravelDataTables ? window.LaravelDataTables['billing-table'] : null;

            const updateSummary = (filters) => {
                const summaryPayload = {
                    start_date: filters.start_date,
                    end_date: filters.end_date,
                    doctor_id: filters.doctor_id,
                    patient_id: filters.patient_id,
                    summary_only: true,
                };

                $.ajax({
                    url: '<?php echo e(route('report.monthly-report')); ?>',
                    type: 'GET',
                    data: summaryPayload,
                    success: function(response) {
                        const count = Number(response.billCount ?? 0);
                        const total = Number(response.billSum ?? 0);
                        const average = count > 0 ? total / count : 0;

                        $('#billCount').text(count.toLocaleString());
                        $('#billSum').text(total.toLocaleString(undefined, {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        }));
                        $('#billAverage').text(average.toLocaleString(undefined, {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        }));

                        if (response.charts) {
                            updateReportCharts(response.charts);
                        }

                        if (response.start_date && response.end_date) {
                            $('.page-subtitle').text('From ' + response.start_date + ' to ' + response.end_date);
                        }
                    }
                });
            };

            const applyFilters = () => {
                const filters = {
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val(),
                    doctor_id: $('#doctor_id').val(),
                    patient_id: $('#patient_id').val(),
                };

                if (billingTable) {
                    if (typeof billingTable.ajax.params === 'function') {
                        const params = billingTable.ajax.params();
                        params.start_date = filters.start_date;
                        params.end_date = filters.end_date;
                        params.doctor_id = filters.doctor_id;
                        params.patient_id = filters.patient_id;
                    }
                    billingTable.ajax.reload(null, true);
                }

                updateSummary(filters);
            };

            form.on('submit', function(event) {
                event.preventDefault();
                applyFilters();
            });

            $('#clearBtn').on('click', function() {
                form.trigger('reset');
                form.find('input[type="text"]').val('');
                selectElements.val(null).trigger('change');
                applyFilters();
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        .reports-monthly .list-card {
            background: transparent;
            border: none;
            box-shadow: none;
        }
        .reports-monthly .list-card .card-body {
            padding: 0;
        }
        .report-shell {
            display: flex;
            flex-direction: column;
            gap: 1.75rem;
        }
        .report-filters {
            background: var(--surface);
            border: 1px solid rgba(148, 163, 184, 0.25);
            border-radius: 1.1rem;
            padding: 1.5rem 1.75rem;
            box-shadow: var(--shadow-sm);
        }
        .filter-heading {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1.5rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }
        .filter-heading h6 {
            font-weight: 700;
            color: var(--text-primary);
        }
        .filter-heading p {
            font-size: .85rem;
        }
        .filter-actions {
            display: flex;
            gap: .75rem;
        }
        .report-filters .form-label {
            font-weight: 600;
            color: var(--text-muted);
        }
        .report-filters .form-control,
        .report-filters .form-select {
            border-radius: .7rem;
            border: 1px solid var(--field-border);
            background: var(--field-bg);
            color: var(--field-text);
        }
        .report-filters .select2-container--default .select2-selection--single {
            height: 44px;
            border-radius: .7rem;
            border: 1px solid var(--field-border);
            background: var(--field-bg);
            padding: .55rem .9rem;
        }
        .report-filters .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.3;
            color: var(--field-text);
        }
        .report-filters .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100%;
            right: .75rem;
        }
        .report-metric-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: var(--surface);
            border: 1px solid rgba(148, 163, 184, 0.25);
            border-radius: 1rem;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.08);
        }
        .report-metric-card .metric-icon {
            width: 48px;
            height: 48px;
            border-radius: 1rem;
            background: rgba(37, 99, 235, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.2rem;
        }
        .report-metric-card .metric-icon-success {
            background: rgba(16, 185, 129, 0.12);
            color: var(--success);
        }
        .report-metric-card .metric-icon-muted {
            background: rgba(148, 163, 184, 0.18);
            color: var(--text-muted);
        }
        .report-metric-card .metric-label {
            font-size: .75rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--text-muted);
            font-weight: 600;
        }
        .report-metric-card .metric-value {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text-primary);
        }
        .report-table-wrapper {
            background: var(--surface);
            border-radius: 1rem;
            border: 1px solid rgba(148, 163, 184, 0.25);
            padding: 1.25rem 1.5rem;
            box-shadow: var(--shadow-sm);
        }
        .report-visuals {
            margin-top: .25rem;
        }
        .report-chart-card {
            background: var(--surface);
            border: 1px solid rgba(148, 163, 184, 0.25);
            border-radius: 0.9rem;
            padding: 0.85rem 1rem;
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-direction: column;
            transition: transform .18s ease, box-shadow .18s ease;
        }
        .report-chart-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 42px rgba(15, 23, 42, 0.12);
        }
        body.theme-light .report-chart-card {
            background: #ffffff;
            border-color: rgba(148, 163, 184, 0.22);
            box-shadow: 0 16px 36px rgba(15, 23, 42, 0.08);
        }
        body.theme-light .chart-header span {
            color: rgba(100, 116, 139, 0.78);
        }
        body.theme-light .report-chart-card .chart-body {
            border-radius: 0.7rem;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.08), rgba(14, 165, 233, 0.08));
            padding: .5rem;
        }
        .chart-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 0.65rem;
        }
        .chart-header h6 {
            font-weight: 700;
            color: var(--text-primary);
        }
        .chart-header span {
            display: block;
            font-size: .8rem;
            color: var(--text-muted);
        }
        .report-chart-card .chart-body {
            position: relative;
            flex: 1 1 auto;
            min-height: 0;
            height: 180px;
        }
        .report-chart-card canvas {
            width: 100%;
            height: 100% !important;
        }
        @media (max-width: 1399.98px) {
            .report-chart-card .chart-body {
                height: 160px;
            }
        }
        @media (max-width: 991.98px) {
            .report-chart-card .chart-body {
                height: 200px;
            }
        }
        @media (max-width: 767.98px) {
            .filter-actions {
                width: 100%;
                justify-content: flex-start;
            }
            .filter-actions .btn {
                flex: 1 1 auto;
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gihan.finsbury/Downloads/Vet-APP/Glowup/resources/views/reports/monthly-report.blade.php ENDPATH**/ ?>