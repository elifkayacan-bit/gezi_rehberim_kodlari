<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Veritabanı dosyanızın adının doğru olduğundan emin olun (baglan.php veya baglanti.php)
include 'baglan.php'; 
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Önerilen Gizli Rotalar - Gezi Rehberim</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Sayfa üstündeki büyük banner alanı tamamen kaldırıldı */
        
        .kategori-baslik {
            max-width: 1200px;
            margin: 40px auto 10px auto;
            padding: 0 20px;
            font-size: 22px;
            color: #1e293b;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 10px;
        }

        .onerilen-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            max-width: 1200px;
            margin: 20px auto 50px auto;
            padding: 0 20px;
        }

        .onerilen-kart {
            background: #ffffff;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            display: flex;
            flex-direction: column;
            transition: transform 0.2s;
        }
        .onerilen-kart:hover {
            transform: translateY(-5px);
        }
        .onerilen-kart img { width: 100%; height: 200px; object-fit: cover; }
        .onerilen-kart-body { padding: 20px; display: flex; flex-direction: column; justify-content: space-between; flex-grow: 1; }
        .onerilen-ust-bilgi { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .onerilen-sehir { font-size: 13px; font-weight: 600; color: #3498db; text-transform: uppercase; }
        .onerilen-puan { background: #fef3c7; color: #d97706; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 700; display: flex; align-items: center; gap: 4px; }
        .onerilen-kart h3 { font-size: 17px; color: #1e293b; margin: 0 0 10px 0; font-weight: 600; }
        .onerilen-aciklama { font-size: 13.5px; color: #64748b; line-height: 1.5; margin: 0; }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="kategori-baslik" style="margin-top: 30px;">
        <i class="fas fa-map-marked-alt" style="color: #2ecc71;"></i> Türkiye'nin Gizli ve İlginç Hazineleri
    </div>

<div class="turkiye-izgara" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; padding: 10px 0; max-width: 1200px; margin: 0 auto; font-family: system-ui, -apple-system, sans-serif;">

    <div style="background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.05); display: flex; flex-direction: column; border: 1px solid #f1f5f9;">
        <div style="height: 200px; width: 100%; overflow: hidden;">
           <img src="images/karanlik_kanyon.jpg" alt="Karanlık Kanyon" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <div style="padding: 20px; display: flex; flex-direction: column; gap: 8px; flex-grow: 1;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 11px; color: #0284c7; font-weight: 600; text-transform: uppercase;"><i class="fas fa-map-marker-alt"></i> ERZİNCAN / KEMALİYE</span>
                <span style="font-size: 11px; background: #fef9c3; color: #854d0e; padding: 2px 8px; border-radius: 12px; font-weight: 700;"><i class="fas fa-star" style="color: #eab308;"></i> 4.8</span>
            </div>
            <h4 style="font-size: 17px; color: #1e293b; margin: 4px 0 0 0; font-weight: 700;">Karanlık Kanyon</h4>
            <p style="font-size: 13px; color: #64748b; margin: 0; line-height: 1.5; min-height: 60px; flex-grow: 1;">Dünyanın en büyük kanyonlarından biridir. Bot turları ve uçurumlara oyulmuş Taş Yolu ile macera severler için tam bir gizli cennettir.</p>
            <a href="detay.php?yer=karanlik_kanyon" style="margin-top: 15px; background: #f8fafc; color: #0284c7; text-align: center; padding: 10px; border-radius: 10px; text-decoration: none; font-size: 13px; font-weight: 600; display: block; border: 1px solid #e2e8f0; transition: all 0.2s;" onmouseover="this.style.background='#e0f2fe'; this.style.borderColor='#bae6fd';" onmouseout="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0';">
                Keşfet <span style="margin-left: 4px;">→</span>
            </a>
        </div>
    </div>

    <div style="background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.05); display: flex; flex-direction: column; border: 1px solid #f1f5f9;">
        <div style="height: 200px; width: 100%; overflow: hidden;">
            <img src="images/cehennem_deresi.jpg" alt="Cehennem Deresi" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <div style="padding: 20px; display: flex; flex-direction: column; gap: 8px; flex-grow: 1;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 11px; color: #0284c7; font-weight: 600; text-transform: uppercase;"><i class="fas fa-map-marker-alt"></i> ARTVİN / ARDANUÇ</span>
                <span style="font-size: 11px; background: #fef9c3; color: #854d0e; padding: 2px 8px; border-radius: 12px; font-weight: 700;"><i class="fas fa-star" style="color: #eab308;"></i> 4.7</span>
            </div>
            <h4 style="font-size: 17px; color: #1e293b; margin: 4px 0 0 0; font-weight: 700;">Cehennem Deresi Kanyonu</h4>
            <p style="font-size: 13px; color: #64748b; margin: 0; line-height: 1.5; min-height: 60px; flex-grow: 1;">Dünyada az sayıda bulunan dik duvarlı kanyonlardandır. Dar yollardan geçilerek ulaşılan bu kanyon büyüleyici bir vahşi doğaya sahiptir.</p>
            <a href="detay.php?yer=cehennem_deresi" style="margin-top: 15px; background: #f8fafc; color: #0284c7; text-align: center; padding: 10px; border-radius: 10px; text-decoration: none; font-size: 13px; font-weight: 600; display: block; border: 1px solid #e2e8f0; transition: all 0.2s;" onmouseover="this.style.background='#e0f2fe'; this.style.borderColor='#bae6fd';" onmouseout="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0';">
                Keşfet <span style="margin-left: 4px;">→</span>
            </a>
        </div>
    </div>

    <div style="background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.05); display: flex; flex-direction: column; border: 1px solid #f1f5f9;">
        <div style="height: 200px; width: 100%; overflow: hidden;">
            <img src="images/44.jpg" alt="Frig Vadisi" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <div style="padding: 20px; display: flex; flex-direction: column; gap: 8px; flex-grow: 1;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 11px; color: #0284c7; font-weight: 600; text-transform: uppercase;"><i class="fas fa-map-marker-alt"></i> ESKİŞEHİR / AFYON</span>
                <span style="font-size: 11px; background: #fef9c3; color: #854d0e; padding: 2px 8px; border-radius: 12px; font-weight: 700;"><i class="fas fa-star" style="color: #eab308;"></i> 4.9</span>
            </div>
            <h4 style="font-size: 17px; color: #1e293b; margin: 4px 0 0 0; font-weight: 700;">Frig Vadisi ve Midas Anıtı</h4>
            <p style="font-size: 13px; color: #64748b; margin: 0; line-height: 1.5; min-height: 60px; flex-grow: 1;">Kapadokya'ya benzeyen kaya yapısı ve binlerce yıllık devasa kaya anıtlarıyla, kalabalıktan uzak tarih kokan mistik bir vadidir.</p>
            <a href="detay.php?yer=frig_vadisi" style="margin-top: 15px; background: #f8fafc; color: #0284c7; text-align: center; padding: 10px; border-radius: 10px; text-decoration: none; font-size: 13px; font-weight: 600; display: block; border: 1px solid #e2e8f0; transition: all 0.2s;" onmouseover="this.style.background='#e0f2fe'; this.style.borderColor='#bae6fd';" onmouseout="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0';">
                Keşfet <span style="margin-left: 4px;">→</span>
            </a>
        </div>
    </div>

    <div style="background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.05); display: flex; flex-direction: column; border: 1px solid #f1f5f9;">
        <div style="height: 200px; width: 100%; overflow: hidden;">
             <img src="images/kaklik_magrasi.jpg" alt="Kaklık Mağarası" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <div style="padding: 20px; display: flex; flex-direction: column; gap: 8px; flex-grow: 1;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 11px; color: #0284c7; font-weight: 600; text-transform: uppercase;"><i class="fas fa-map-marker-alt"></i> DENİZLİ</span>
                <span style="font-size: 11px; background: #fef9c3; color: #854d0e; padding: 2px 8px; border-radius: 12px; font-weight: 700;"><i class="fas fa-star" style="color: #eab308;"></i> 4.8</span>
            </div>
            <h4 style="font-size: 17px; color: #1e293b; margin: 4px 0 0 0; font-weight: 700;">Kaklık Mağarası (Yeraltı Pamukkalesi)</h4>
            <p style="font-size: 13px; color: #64748b; margin: 0; line-height: 1.5; min-height: 60px; flex-grow: 1;">Pamukkale'nin yer altındaki şubesi gibidir. Mağaranın içinde travertenler, termal sular ve eşine az rastlanır sarkıtlar bulunur.</p>
            <a href="detay.php?yer=kaklik_magarasi" style="margin-top: 15px; background: #f8fafc; color: #0284c7; text-align: center; padding: 10px; border-radius: 10px; text-decoration: none; font-size: 13px; font-weight: 600; display: block; border: 1px solid #e2e8f0; transition: all 0.2s;" onmouseover="this.style.background='#e0f2fe'; this.style.borderColor='#bae6fd';" onmouseout="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0';">
                Keşfet <span style="margin-left: 4px;">→</span>
            </a>
        </div>
    </div>

    <div style="background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.05); display: flex; flex-direction: column; border: 1px solid #f1f5f9;">
        <div style="height: 200px; width: 100%; overflow: hidden;">
             <img src="images/gideros_koyu.jpg" alt="Gideros Koyu" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <div style="padding: 20px; display: flex; flex-direction: column; gap: 8px; flex-grow: 1;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 11px; color: #0284c7; font-weight: 600; text-transform: uppercase;"><i class="fas fa-map-marker-alt"></i> KASTAMONU / CİDE</span>
                <span style="font-size: 11px; background: #fef9c3; color: #854d0e; padding: 2px 8px; border-radius: 12px; font-weight: 700;"><i class="fas fa-star" style="color: #eab308;"></i> 4.9</span>
            </div>
            <h4 style="font-size: 17px; color: #1e293b; margin: 4px 0 0 0; font-weight: 700;">Gideros Koyu</h4>
            <p style="font-size: 13px; color: #64748b; margin: 0; line-height: 1.5; min-height: 60px; flex-grow: 1;">Karadeniz'in hırçın dalgalarından saklanmış, yemyeşil ağaçların denizle birleştiği, akvaryum gibi durgun ve gizli bir balıkçı koyudur.</p>
            <a href="detay.php?yer=gideros_koyu" style="margin-top: 15px; background: #f8fafc; color: #0284c7; text-align: center; padding: 10px; border-radius: 10px; text-decoration: none; font-size: 13px; font-weight: 600; display: block; border: 1px solid #e2e8f0; transition: all 0.2s;" onmouseover="this.style.background='#e0f2fe'; this.style.borderColor='#bae6fd';" onmouseout="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0';">
                Keşfet <span style="margin-left: 4px;">→</span>
            </a>
        </div>
    </div>

    <div style="background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.05); display: flex; flex-direction: column; border: 1px solid #f1f5f9;">
        <div style="height: 200px; width: 100%; overflow: hidden;">
            <img src="images/blaundos.jpg" alt="Blaundus Antik Kenti" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <div style="padding: 20px; display: flex; flex-direction: column; gap: 8px; flex-grow: 1;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 11px; color: #0284c7; font-weight: 600; text-transform: uppercase;"><i class="fas fa-map-marker-alt"></i> UŞAK</span>
                <span style="font-size: 11px; background: #fef9c3; color: #854d0e; padding: 2px 8px; border-radius: 12px; font-weight: 700;"><i class="fas fa-star" style="color: #eab308;"></i> 4.6</span>
            </div>
            <h4 style="font-size: 17px; color: #1e293b; margin: 4px 0 0 0; font-weight: 700;">Blaundus Antik Kenti</h4>
            <p style="font-size: 13px; color: #64748b; margin: 0; line-height: 1.5; min-height: 60px; flex-grow: 1;">Derin bir kanyonun ortasındaki yarımada üzerine kurulmuş, Stonehenge anıtlarını andıran kapılarıyla geceleri harika gökyüzü manzarası sunan antik kent.</p>
            <a href="detay.php?yer=blaundus" style="margin-top: 15px; background: #f8fafc; color: #0284c7; text-align: center; padding: 10px; border-radius: 10px; text-decoration: none; font-size: 13px; font-weight: 600; display: block; border: 1px solid #e2e8f0; transition: all 0.2s;" onmouseover="this.style.background='#e0f2fe'; this.style.borderColor='#bae6fd';" onmouseout="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0';">
                Keşfet <span style="margin-left: 4px;">→</span>
            </a>
        </div>
    </div>

</div>


    <div class="kategori-baslik">
        <i class="fas fa-globe-europe" style="color: #3498db;"></i> Yurt Dışından Sıra Dışı Estetik Rotalar
    </div>
   


<div class="yurtdisi-izgara" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; padding: 10px 0; max-width: 1200px; margin: 0 auto; font-family: system-ui, -apple-system, sans-serif;">

    <div style="background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.05); display: flex; flex-direction: column; border: 1px solid #f1f5f9;">
        <div style="height: 200px; width: 100%; overflow: hidden;">
          <img src="images/giethoorn.jpg" alt="Giethoorn" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <div style="padding: 20px; display: flex; flex-direction: column; gap: 8px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 12px; color: #0284c7; font-weight: 600; text-transform: uppercase; display: flex; align-items: center; gap: 4px;">
                    <i class="fas fa-map-marker-alt"></i> HOLLANDA
                </span>
                <span style="font-size: 12px; background: #fef9c3; color: #854d0e; padding: 2px 8px; border-radius: 12px; font-weight: 700; display: flex; align-items: center; gap: 4px;">
                    <i class="fas fa-star" style="color: #eab308;"></i> 4.9
                </span>
            </div>
            <h4 style="font-size: 18px; color: #1e293b; margin: 4px 0 0 0; font-weight: 700;">Giethoorn (Arabasız Köy)</h4>
            <p style="font-size: 13px; color: #64748b; margin: 0; line-height: 1.5; min-height: 60px;">Hiç araba yolunun olmadığı, ulaşımın tamamen kanallarda sandallarla veya ahşap köprülerden yürüyerek sağlandığı masal köyü.</p>
            <a href="detay.php?yer=giethoorn" style="margin-top: 10px; background: #f8fafc; color: #0284c7; text-align: center; padding: 10px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600; transition: background 0.2s;" onmouseover="this.style.background='#e0f2fe'" onmouseout="this.style.background='#f8fafc'">
                Keşfet <i class="fas fa-arrow-right" style="font-size: 11px; margin-left: 4px;"></i>
            </a>
        </div>
    </div>

    <div style="background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.05); display: flex; flex-direction: column; border: 1px solid #f1f5f9;">
        <div style="height: 200px; width: 100%; overflow: hidden;">
            <img src="images/blend.jpg" alt="Bled Gölü" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <div style="padding: 20px; display: flex; flex-direction: column; gap: 8px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 12px; color: #0284c7; font-weight: 600; text-transform: uppercase; display: flex; align-items: center; gap: 4px;">
                    <i class="fas fa-map-marker-alt"></i> SLOVENYA
                </span>
                <span style="font-size: 12px; background: #fef9c3; color: #854d0e; padding: 2px 8px; border-radius: 12px; font-weight: 700; display: flex; align-items: center; gap: 4px;">
                    <i class="fas fa-star" style="color: #eab308;"></i> 5.0
                </span>
            </div>
            <h4 style="font-size: 18px; color: #1e293b; margin: 4px 0 0 0; font-weight: 700;">Bled Gölü ve Kilisesi</h4>
            <p style="font-size: 13px; color: #64748b; margin: 0; line-height: 1.5; min-height: 60px;">Alp Dağları'nın eteğinde, gölün tam ortasındaki mini adada yer alan kilisesiyle dünyadan soyutlanmış gibi duran huzur rotası.</p>
            <a href="detay.php?yer=bled_golu" style="margin-top: 10px; background: #f8fafc; color: #0284c7; text-align: center; padding: 10px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600; transition: background 0.2s;" onmouseover="this.style.background='#e0f2fe'" onmouseout="this.style.background='#f8fafc'">
                Keşfet <i class="fas fa-arrow-right" style="font-size: 11px; margin-left: 4px;"></i>
            </a>
        </div>
    </div>

    <div style="background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.05); display: flex; flex-direction: column; border: 1px solid #f1f5f9;">
        <div style="height: 200px; width: 100%; overflow: hidden;">
          <img src="images/hallstat.jpg" alt="Hallstatt" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <div style="padding: 20px; display: flex; flex-direction: column; gap: 8px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 12px; color: #0284c7; font-weight: 600; text-transform: uppercase; display: flex; align-items: center; gap: 4px;">
                    <i class="fas fa-map-marker-alt"></i> AVUSTURYA
                </span>
                <span style="font-size: 12px; background: #fef9c3; color: #854d0e; padding: 2px 8px; border-radius: 12px; font-weight: 700; display: flex; align-items: center; gap: 4px;">
                    <i class="fas fa-star" style="color: #eab308;"></i> 4.8
                </span>
            </div>
            <h4 style="font-size: 18px; color: #1e293b; margin: 4px 0 0 0; font-weight: 700;">Hallstatt Kasabası</h4>
            <p style="font-size: 13px; color: #64748b; margin: 0; line-height: 1.5; min-height: 60px;">Bir dağın yamacına dizilmiş tarihi ahşap evleri ve nefes kesen göl manzarasıyla dünyanın en güzel korunan göl kenarı kasabalarından biridir.</p>
            <a href="detay.php?yer=hallstatt" style="margin-top: 10px; background: #f8fafc; color: #0284c7; text-align: center; padding: 10px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600; transition: background 0.2s;" onmouseover="this.style.background='#e0f2fe'" onmouseout="this.style.background='#f8fafc'">
                Keşfet <i class="fas fa-arrow-right" style="font-size: 11px; margin-left: 4px;"></i>
            </a>
        </div>
    </div>

</div>


</body>
</html>