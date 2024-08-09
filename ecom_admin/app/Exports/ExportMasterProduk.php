<?php
namespace App;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\MasterProduk;

class ExportMasterProduk implements FromCollection, WithHeadings
{
    use Exportable;

    public function query()
    {
        return MasterProduk::with('master_produk_harga_grosir','master_produk_properties.master_properties','master_kategori','master_subkategori')->get();
    }

    public function headings(): array
    {
        return ["SKU","KATA KUNCI","NAMA PRODUK","KATEGORI","SUBKATEGORI","URL VIDEO","SATUAN","MINIMAL ORDER","DISKON","BERAT","HARGA BELI","HARGA JUAL B2C","HARGA JUAL B2B","STOCK","READY STOCK","HARGA GROSIR","PROPERTIES"];
    }
}