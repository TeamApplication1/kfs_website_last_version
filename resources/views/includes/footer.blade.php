<footer class="site-footer-new">
    <div class="container">
        <div class="footer-body">
            <div class="footer-brand-col">
                <img src="{{ Storage::url($settings['site_logo_footer'] ?? '') }}" alt="{{ $settings['site_name'] ?? 'محافظة كفر الشيخ' }}" class="footer-logo-main">
                <p class="footer-desc">
                    {{ $settings['footer_description'] ?? 'البوابة الإلكترونية الرسمية لمحافظة كفر الشيخ — نعمل معاً لخدمة المواطن وتحقيق التنمية المستدامة.' }}
                </p>
                <div class="footer-socials">
                    @php
                        $socials = [
                            'facebook'  => ['fa-facebook-f',   $settings['social_facebook'] ?? ''],
                            'twitter'   => ['fa-x-twitter',    $settings['social_twitter'] ?? ''],
                            'instagram' => ['fa-instagram',    $settings['social_instagram'] ?? ''],
                            'youtube'   => ['fa-youtube',      $settings['social_youtube'] ?? ''],
                            'tiktok'    => ['fa-tiktok',       $settings['social_tiktok'] ?? ''],
                        ];
                    @endphp
                    @foreach ($socials as $name => $data)
                        @if ($data[1])
                            <a href="{{ $data[1] }}" class="social-{{ $name }}" aria-label="{{ ucfirst($name) }}" target="_blank" rel="noopener">
                                <i class="fab {{ $data[0] }}"></i>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="footer-links-col">
                <div class="footer-links-group">
                    <h5 class="footer-heading">عن المحافظة</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('posts.index') }}"><i class="fas fa-newspaper ms-2"></i>الأخبار</a></li>
                        <li><a href="{{ route('investments.index') }}"><i class="fas fa-chart-line ms-2"></i>الاستثمار</a></li>
                        <li><a href="{{ route('services.index') }}"><i class="fas fa-concierge-bell ms-2"></i>الخدمات</a></li>
                        <li><a href="{{ route('projects.index') }}"><i class="fas fa-building-flag ms-2"></i>المشروعات</a></li>
                    </ul>
                </div>
                <div class="footer-links-group">
                    <h5 class="footer-heading">مواقع مهمة</h5>
                    <ul class="footer-links">
                        <li><a href="https://www.egypt.gov.eg" target="_blank"><i class="fas fa-desktop ms-2"></i>مصر الرقمية</a></li>
                        <li><a href="https://jobs.egypt.gov.eg" target="_blank"><i class="fas fa-briefcase ms-2"></i>بوابة الوظائف</a></li>
                        <li><a href="https://etenders.gov.eg" target="_blank"><i class="fas fa-file-signature ms-2"></i>بوابة التعاقدات</a></li>
                        <li><a href="https://www.takaful.gov.eg" target="_blank"><i class="fas fa-hand-holding-heart ms-2"></i>التضامن الاجتماعي</a></li>
                        <li><a href="https://www.sis.gov.eg" target="_blank"><i class="fas fa-info-circle ms-2"></i>الهيئة العامة للاستعلامات</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            <span class="footer-copy-text">
                {!! $settings['copyright_text'] ?? 'جميع الحقوق محفوظة &copy; محافظة كفر الشيخ' !!}
                <span class="footer-year-badge" id="footer-year"></span>
            </span>
        </div>
    </div>
</footer>
<script>
    document.getElementById('footer-year') && (document.getElementById('footer-year').textContent = new Date().getFullYear());
</script>
