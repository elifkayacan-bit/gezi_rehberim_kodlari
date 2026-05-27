<?php
// Türkçe karakterleri güvenli bir şekilde küçülten yardımcı fonksiyon
function turkce_kucult($metin) {
    $bul = array('İ', 'I', 'Ş', 'Ş', 'Ç', 'Ç', 'Ğ', 'Ğ', 'Ü', 'Ü', 'Ö', 'Ö');
    $degistir = array('i', 'ı', 's', 's', 'c', 'c', 'g', 'g', 'u', 'u', 'o', 'o');
    $metin = str_replace($bul, $degistir, $metin);
    return mb_strtolower($metin, 'UTF-8');
}

$sehirler_listesi = [
    // 1 => MARMARA BÖLGESİ
    ['bolge' => 1, 'sehir' => 0, 'ad' => 'İstanbul'],
    ['bolge' => 1, 'sehir' => 1, 'ad' => 'Bursa'],
    ['bolge' => 1, 'sehir' => 2, 'ad' => 'Edirne'],
    ['bolge' => 1, 'sehir' => 3, 'ad' => 'Çanakkale'],
    ['bolge' => 1, 'sehir' => 4, 'ad' => 'Sakarya'],
    ['bolge' => 1, 'sehir' => 5, 'ad' => 'Tekirdağ'],
    ['bolge' => 1, 'sehir' => 6, 'ad' => 'Kocaeli'],

    // 2 => İÇ ANADOLU BÖLGESİ
    ['bolge' => 2, 'sehir' => 0, 'ad' => 'Ankara'],
    ['bolge' => 2, 'sehir' => 1, 'ad' => 'Nevşehir'],
    ['bolge' => 2, 'sehir' => 2, 'ad' => 'Konya'],
    ['bolge' => 2, 'sehir' => 3, 'ad' => 'Eskişehir'],
    ['bolge' => 2, 'sehir' => 4, 'ad' => 'Kayseri'],
    ['bolge' => 2, 'sehir' => 5, 'ad' => 'Sivas'],
    ['bolge' => 2, 'sehir' => 6, 'ad' => 'Aksaray'],

    // 3 => EGE BÖLGESİ
    ['bolge' => 3, 'sehir' => 0, 'ad' => 'İzmir'],
    ['bolge' => 3, 'sehir' => 1, 'ad' => 'Muğla'],
    ['bolge' => 3, 'sehir' => 2, 'ad' => 'Aydın'],
    ['bolge' => 3, 'sehir' => 3, 'ad' => 'Denizli'],
    ['bolge' => 3, 'sehir' => 4, 'ad' => 'Manisa'],
    ['bolge' => 3, 'sehir' => 5, 'ad' => 'Afyonkarahisar'],

    // 4 => AKDENİZ BÖLGESİ
    ['bolge' => 4, 'sehir' => 0, 'ad' => 'Antalya'],
    ['bolge' => 4, 'sehir' => 1, 'ad' => 'Adana'],
    ['bolge' => 4, 'sehir' => 2, 'ad' => 'Mersin'],
    ['bolge' => 4, 'sehir' => 3, 'ad' => 'Hatay'],
    ['bolge' => 4, 'sehir' => 4, 'ad' => 'Kahramanmaraş'],
    ['bolge' => 4, 'sehir' => 5, 'ad' => 'Isparta'],

    // 5 => KARADENİZ BÖLGESİ
    ['bolge' => 5, 'sehir' => 0, 'ad' => 'Trabzon'],
    ['bolge' => 5, 'sehir' => 1, 'ad' => 'Rize'],
    ['bolge' => 5, 'sehir' => 2, 'ad' => 'Samsun'],
    ['bolge' => 5, 'sehir' => 3, 'ad' => 'Ordu'],
    ['bolge' => 5, 'sehir' => 4, 'ad' => 'Amasya'],
    ['bolge' => 5, 'sehir' => 5, 'ad' => 'Sinop'],

    // 6 => DOĞU ANADOLU BÖLGESİ
    ['bolge' => 6, 'sehir' => 0, 'ad' => 'Erzurum'],
    ['bolge' => 6, 'sehir' => 1, 'ad' => 'Van'],
    ['bolge' => 6, 'sehir' => 2, 'ad' => 'Kars'],
    ['bolge' => 6, 'sehir' => 3, 'ad' => 'Ağrı'],

    // 7 => GÜNEYDOĞU ANADOLU BÖLGESİ
    ['bolge' => 7, 'sehir' => 0, 'ad' => 'Şanlıurfa'],
    ['bolge' => 7, 'sehir' => 1, 'ad' => 'Mardin'],
    ['bolge' => 7, 'sehir' => 2, 'ad' => 'Gaziantep'],
    ['bolge' => 7, 'sehir' => 3, 'ad' => 'Adıyaman'],
    ['bolge' => 7, 'sehir' => 4, 'ad' => 'Diyarbakır'],
    ['bolge' => 7, 'sehir' => 5, 'ad' => 'Batman']
];

if (isset($_POST['kelime'])) {
    $kelime = trim($_POST['kelime']);
    $kelime_kucuk = turkce_kucult($kelime);
    
    if (!empty($kelime_kucuk)) {
        $bulunan_sayisi = 0;
        
        foreach ($sehirler_listesi as $s) {
            $sehir_isim_kucuk = turkce_kucult($s['ad']);
            
            // strpos !== false yaparak akıllı aramaya geçtik. İçinde harf geçen tüm şehirleri bulur.
            if (strpos($sehir_isim_kucuk, $kelime_kucuk) !== false) {
                $link_adresi = "sehir.php?id=" . $s['bolge'] . "&sehir_sira=" . $s['sehir'];
                
                echo '<a href="' . $link_adresi . '" class="sehir-satir" style="display: block; text-decoration: none; color: #1e293b; padding: 12px 20px; font-weight: 500;">';
                echo '<i class="fas fa-map-marker-alt" style="color: #38bdf8; margin-right: 10px;"></i> ';
                echo '<span>' . $s['ad'] . '</span>';
                echo '</a>';
                $bulunan_sayisi++;
            }
        }
        
        if ($bulunan_sayisi === 0) {
            echo '<div style="padding: 14px 22px; color: #94a3b8; font-size: 14px; text-align: center;">Kayıtlı şehir bulunamadı...</div>';
        }
    }
}
?>