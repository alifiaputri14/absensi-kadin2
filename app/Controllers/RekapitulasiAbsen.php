<?php

namespace App\Controllers;

use App\Models\presensiModel;

class RekapitulasiAbsen extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $modelPresensi = new presensiModel();

        // Gunakan pagination
        $pagination = $this->paginateData();
        $data['data_presensi'] = $modelPresensi
            ->select('presensi.*, user.nama as Nama')
            ->join('user', 'user.id_magang = presensi.id_magang')
            ->orderBy('tanggal', 'desc')
            ->findAll($pagination['perPage'], $pagination['offset']);

        $data = array_merge($data, $pagination); // Gabungkan data pagination ke $data

        $data['tanggal_hari_ini'] = $this->getTanggalHariIni();

        $data['title'] = 'Rekapitulasi Absensi';
        return view('rekapitulasi', $data);
    }

    private function paginateData(?string $tanggal = null): array
    {
        $modelPresensi = new presensiModel();
        $perPage = 10;
    
        // Dapatkan nomor halaman saat ini
        $page = $this->request->getVar('page') ?? 1;
    
        // Hitung offset
        $offset = ($page - 1) * $perPage;
    
        // Hitung total data
        if ($tanggal) {
            $totalRecords = $modelPresensi->where('tanggal', $tanggal)->countAllResults();
        } else {
            $totalRecords = $modelPresensi->countAllResults();
        }
    
        // Hitung total halaman
        $totalPages = ceil($totalRecords / $perPage);
    
        // Kembalikan data pagination
        return [
            'perPage' => $perPage,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'offset' => $offset
        ];
    }
    
    public function Filtertanggal()
    {
        $tanggal = $this->request->getGet('tanggal');
        $modelPresensi = new presensiModel();
    
        // paginate sesuai tanggal
        $pagination = $this->paginateData($tanggal);
    
        if ($tanggal) {
            $data['data_presensi'] = $modelPresensi
                ->select('presensi.*, user.nama as Nama')
                ->join('user', 'user.id_magang = presensi.id_magang')
                ->where('tanggal', $tanggal)
                ->orderBy('tanggal', 'desc')
                ->findAll($pagination['perPage'], $pagination['offset']);
            $data['tanggal_pilih'] = $tanggal;
        } else {
            $data['data_presensi'] = $modelPresensi
                ->select('presensi.*, user.nama as Nama')
                ->join('user', 'user.id_magang = presensi.id_magang')
                ->orderBy('tanggal', 'desc')
                ->findAll($pagination['perPage'], $pagination['offset']);
            $data['tanggal_pilih'] = null;
        }
    
        $data = array_merge($data, $pagination); // Gabungkan data 
    
        $data['tanggal_hari_ini'] = $this->getTanggalHariIni();
    
        $data['title'] = 'Rekapitulasi Absensi';
        return view('rekapitulasi', $data);
    }

    private function getTanggalHariIni(): string
    {
        $hari = date('l');
        $tanggal = date('j');
        $bulan = date('F');
        $tahun = date('Y');

        $namaHari = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];

        $namaBulan = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];

        return $namaHari[$hari] . ', ' . $tanggal . ' ' . $namaBulan[$bulan] . ' ' . $tahun;
    }

    public function delete($id_presensi)
    {
        $modelPresensi = new presensiModel();
        $modelPresensi->delete($id_presensi);
        
        return redirect()->to(site_url('rekapitulasi'))->with('success', 'Data berhasil dihapus.');
    }

    public function detail($id_presensi)
    {
        $modelPresensi = new presensiModel();

        // Dapatkan data presensi berdasarkan id
        $data['presensi'] = $modelPresensi
            ->select('presensi.*, user.nama as Nama')
            ->join('user', 'user.id_magang = presensi.id_magang')
            ->where('id_presensi', $id_presensi)
            ->first();

        if (!$data['presensi']) {
            return redirect()->to(site_url('rekapitulasi'))->with('error', 'Data tidak ditemukan.');
        }

        $data['title'] = 'Detail Presensi';
        return view('detailpresensi', $data);
    }
}