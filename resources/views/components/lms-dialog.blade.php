<div x-data="lmsDialog()" x-cloak class="contents"
     @lms-dialog-alert.window="openAlert($event.detail)"
     @lms-dialog-confirm.window="openConfirm($event.detail)">
    {{-- Alert --}}
    <div x-show="alertOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="lms-dialog-overlay"
         style="display:none;">
        <div class="lms-dialog-backdrop" @click="closeAlert()"></div>
        <div class="lms-dialog-panel" role="alertdialog" aria-modal="true" @keydown.escape.window="closeAlert()">
            <div class="lms-dialog-body">
                <div class="lms-dialog-icon lms-dialog-icon--info">ℹ️</div>
                <div class="lms-dialog-content">
                    <h3 class="lms-dialog-title">Informasi</h3>
                    <p class="lms-dialog-message" x-text="message"></p>
                </div>
            </div>
            <div class="lms-dialog-footer">
                <button type="button" @click="closeAlert()" class="lms-btn-primary">OK</button>
            </div>
        </div>
    </div>

    {{-- Confirm --}}
    <div x-show="confirmOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="lms-dialog-overlay"
         style="display:none;">
        <div class="lms-dialog-backdrop" @click="confirmNo()"></div>
        <div class="lms-dialog-panel" role="alertdialog" aria-modal="true" @keydown.escape.window="confirmNo()">
            <div class="lms-dialog-body">
                <div class="lms-dialog-icon lms-dialog-icon--warning">⚠️</div>
                <div class="lms-dialog-content">
                    <h3 class="lms-dialog-title">Konfirmasi</h3>
                    <p class="lms-dialog-message" x-text="message"></p>
                </div>
            </div>
            <div class="lms-dialog-footer lms-dialog-footer--split">
                <button type="button" @click="confirmNo()" class="lms-btn-secondary">Batal</button>
                <button type="button" @click="confirmYes()" class="lms-btn-primary">Ya, Lanjutkan</button>
            </div>
        </div>
    </div>
</div>
