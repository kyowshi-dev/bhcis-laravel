<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="md:col-span-1 space-y-6">
        
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <h2 class="text-xl font-bold text-gray-800"><?php echo e($patient->last_name); ?>, <?php echo e($patient->first_name); ?></h2>
            <p class="text-sm text-gray-500 mb-4">Patient ID: <?php echo e($patient->id); ?></p>
            <div class="text-sm space-y-2">
                <div class="flex justify-between"><span>Sex:</span> <span class="font-medium"><?php echo e($patient->sex); ?></span></div>
                <div class="flex justify-between"><span>Age:</span> <span class="font-medium"><?php echo e(\Carbon\Carbon::parse($patient->date_of_birth)->age); ?> y/o</span></div>
            </div>
        </div>

        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
            <h3 class="font-bold text-blue-800 mb-3 flex items-center gap-2">
                <span>📊 Vital Signs</span>
            </h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-blue-500 block text-xs uppercase">BP</span>
                    <span class="font-bold text-lg text-gray-700">
                        <?php echo e($vitals->bp_systolic ?? '--'); ?>/<?php echo e($vitals->bp_diastolic ?? '--'); ?>

                    </span>
                </div>
                <div>
                    <span class="text-blue-500 block text-xs uppercase">Temp</span>
                    <span class="font-bold text-lg text-gray-700"><?php echo e($vitals->temperature_c); ?>°C</span>
                </div>
                <div>
                    <span class="text-blue-500 block text-xs uppercase">Weight</span>
                    <span class="font-bold text-lg text-gray-700"><?php echo e($vitals->weight_kg ?? '--'); ?> kg</span>
                </div>
                <div>
                    <span class="text-blue-500 block text-xs uppercase">BMI</span>
                    <span class="font-bold text-lg text-gray-700"><?php echo e($vitals->bmi ?? '--'); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="md:col-span-2 space-y-6">

        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">🩺 Medical Diagnosis</h3>

            <?php if($diagnoses->count() > 0): ?>
                <div class="mb-6 space-y-2">
                    <?php $__currentLoopData = $diagnoses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex justify-between items-center bg-green-50 p-3 rounded border border-green-100">
                            <div>
                                <span class="font-bold text-green-800"><?php echo e($d->diagnosis_code); ?></span>
                                <span class="text-gray-700 ml-2"><?php echo e($d->diagnosis_name); ?></span>
                            </div>
                            <span class="text-xs text-gray-400">Saved</span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('consultations.diagnosis', $consultation->id)); ?>" method="POST" x-data="diagnosisSearch()">
                <?php echo csrf_field(); ?>
                <div class="relative mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search ICD-10 / Disease Name</label>
                    
                    <input 
                        type="text" 
                        x-model="query"
                        @input.debounce.300ms="search()"
                        placeholder="Type to search (e.g. Dengue, Hypertension)..."
                        class="w-full p-3 border border-gray-300 rounded focus:ring-2 focus:ring-green-500 outline-none"
                        autocomplete="off"
                    >

                    <input type="hidden" name="diagnosis_id" x-model="selectedId">

                    <div x-show="results.length > 0" class="absolute z-10 w-full bg-white mt-1 border border-gray-200 rounded shadow-xl max-h-60 overflow-y-auto" style="display: none;">
                        <ul>
                            <template x-for="item in results" :key="item.id">
                                <li @click="select(item)" class="p-3 hover:bg-green-50 cursor-pointer border-b last:border-0">
                                    <span class="font-bold text-gray-800" x-text="item.text"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Medical Notes / Remarks</label>
                    <textarea name="remarks" rows="2" class="w-full p-2 border rounded" placeholder="Additional notes..."></textarea>
                </div>

                <div class="text-right">
                    <button type="submit" :disabled="!selectedId" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded font-bold disabled:opacity-50">
                        Add Diagnosis
			<div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 mt-6">
            <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">💊 Prescription (Rx)</h3>

            <?php if(isset($prescriptions) && $prescriptions->count() > 0): ?>
                <div class="mb-6 space-y-2">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-500 text-left">
                            <tr>
                                <th class="p-2">Medicine</th>
                                <th class="p-2">Dosage</th>
                                <th class="p-2">Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $prescriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b last:border-0">
                                <td class="p-2 font-bold text-gray-700"><?php echo e($rx->medicine_name); ?></td>
                                <td class="p-2"><?php echo e($rx->dosage); ?> (<?php echo e($rx->duration); ?>)</td>
                                <td class="p-2 text-center bg-gray-50 rounded"><?php echo e($rx->quantity); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('consultations.prescription', $consultation->id)); ?>" method="POST" x-data="medicineSearch()">
                <?php echo csrf_field(); ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <div class="md:col-span-2 relative">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Search Medicine</label>
                        <input 
                            type="text" 
                            x-model="query"
                            @input.debounce.300ms="search()"
                            placeholder="e.g. Paracetamol, Amoxicillin..."
                            class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-green-500 outline-none"
                            autocomplete="off"
                        >
                        <input type="hidden" name="medicine_id" x-model="selectedId">

                        <div x-show="results.length > 0" class="absolute z-10 w-full bg-white mt-1 border border-gray-200 rounded shadow-xl max-h-40 overflow-y-auto" style="display: none;">
                            <ul>
                                <template x-for="item in results" :key="item.id">
                                    <li @click="select(item)" class="p-2 hover:bg-green-50 cursor-pointer border-b text-sm">
                                        <span class="font-bold text-gray-800" x-text="item.text"></span>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sig. / Dosage</label>
                        <input type="text" name="dosage" placeholder="e.g. 1 tab every 4hrs" class="w-full p-2 border rounded" required>
                    </div>

                    <div class="flex gap-2">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Qty</label>
                            <input type="number" name="quantity" placeholder="10" class="w-full p-2 border rounded" required>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Duration</label>
                            <input type="text" name="duration" placeholder="e.g. 3 days" class="w-full p-2 border rounded">
                        </div>
                    </div>

                </div>

                <div class="text-right mt-4">
                    <button type="submit" :disabled="!selectedId" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-bold disabled:opacity-50">
                        + Add Rx
                    </button>
                </div>
            </form>
        </div>

        <script>
            function medicineSearch() {
                return {
                    query: '',
                    results: [],
                    selectedId: null,

                    async search() {
                        if (this.query.length < 2) return;
                        let response = await fetch(`/search/medicines?query=${this.query}`);
                        this.results = await response.json();
                    },

                    select(item) {
                        this.query = item.text;
                        this.selectedId = item.id;
                        this.results = [];
                    }
                }
            }
   	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/charlz/web_app/bhcis-new/resources/views/consultations/show.blade.php ENDPATH**/ ?>