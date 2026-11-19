<?php
// LAB 6 — Abstraction & polymorphism
// Spesifikasi:
//  - abstract BangunDatar: abstract luas(): float, abstract keliling(): float
//  - Lingkaran(float $r), Persegi(float $sisi), PersegiPanjang(float $p, float $l)
//  - interface Notifikasi { kirim(string $pesan): string }
//      Email, WhatsApp, SMS implements Notifikasi
//  - function kirimSemua(array $notifikasi, string $pesan): array (hasil tiap kirim)

abstract class BangunDatar
{
    abstract public function luas(): float;
    abstract public function keliling(): float;
}

class Lingkaran extends BangunDatar
{
    public function __construct(private float $r) {}

    public function luas(): float
    {
        return pi() * $this->r * $this->r;
    }

    public function keliling(): float
    {
        return 2 * pi() * $this->r;
    }
}

class Persegi extends BangunDatar
{
    public function __construct(private float $sisi) {}

    public function luas(): float
    {
        return $this->sisi * $this->sisi;
    }

    public function keliling(): float
    {
        return 4 * $this->sisi;
    }
}

class PersegiPanjang extends BangunDatar
{
    public function __construct(private float $p, private float $l) {}

    public function luas(): float
    {
        return $this->p * $this->l;
    }

    public function keliling(): float
    {
        return 2 * ($this->p + $this->l);
    }
}
interface Notifikasi
{
    public function kirim(string $pesan): string;
}

class Email implements Notifikasi
{
    public function kirim(string $pesan): string
    {
        return "Notif via Email: {$pesan}";
    }
}

class WhatsApp implements Notifikasi
{
    public function kirim(string $pesan): string
    {
        return "Notif via WhatsApp: {$pesan}";
    }
}

class SMS implements Notifikasi
{
    public function kirim(string $pesan): string
    {
        return "Notif via SMS: {$pesan}";
    }
}
function kirimSemua(array $notifikasi, string $pesan): array
{
    $hasil = [];
    foreach ($notifikasi as $notif) {
        if ($notif instanceof Notifikasi) {
            $hasil[] = $notif->kirim($pesan);
        }
    }
    return $hasil;
}
$lingkaran = new Lingkaran(7);
echo "Luas Lingkaran: " . round($lingkaran->luas(), 2) . PHP_EOL;
echo "Keliling Lingkaran: " . round($lingkaran->keliling(), 2) . PHP_EOL;

$persegi = new Persegi(5);
echo "Luas Persegi: " . $persegi->luas() . PHP_EOL;

$persegiPanjang = new PersegiPanjang(10, 5);
echo "Keliling Persegi Panjang: " . $persegiPanjang->keliling() . PHP_EOL;

echo "------------------------\n";
$layananNotif = [
    new Email(),
    new WhatsApp(),
    new SMS()
];

$pesanBroadcast = "Halo, server akan maintenance jam 12 malam!";
$logPengiriman = kirimSemua($layananNotif, $pesanBroadcast);
foreach ($logPengiriman as $log) {
    echo $log . PHP_EOL;
}