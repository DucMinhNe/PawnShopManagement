<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HopDongCamDo;
use DataTables;
use File;
class HopDongCamDoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = HopDongCamDo::where('trang_thai', 1)
                ->latest()
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editBtn"><i class="fas fa-pencil-alt"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteBtn"><i class="fas fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.hopdongcamdos.index');
    }
    public function getInactiveData(Request $request)
    {
        if ($request->ajax()) {
            $data = HopDongCamDo::where('trang_thai', 0)
                ->latest()
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Restore" class="restore btn btn-success btn-sm restoreBtn"><i class="fa-solid fa-trash-can-arrow-up"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return response()->json(['error' => 'Invalid request.']);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $imageName = $request->input('hinh_anh_mon_hang_hidden');
        if ($request->hasFile('hinh_anh_mon_hang')) {
            $oldImage = HopDongCamDo::where('id', $request->id)->value('hinh_anh_mon_hang');
            if ($oldImage && File::exists('monhang_img/' . $oldImage)) {
                File::delete('monhang_img/' . $oldImage);
            }
            $file = $request->file('hinh_anh_mon_hang');
            $destinationPath = 'monhang_img/';
            $imageName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $imageName);
        }

        $request->validate([
            'ten_mon_hang' => ['required', 'string'],
            'mo_ta' => ['nullable', 'string'],
            'nguoi_cam' => ['required', 'string'],
            'so_dien_thoai' => ['required', 'regex:/^(0|\+84)?([3-9]\d{8})$/'],
            'so_cmnd' => ['required', 'regex:/\d{9}|\d{12}/'],
            'ngay_cam' => ['required', 'date'],
            'ngay_het_han_cam' => ['nullable', 'date'],
            'lai_suat' => ['required', 'numeric'],
            'so_tien_cam' => ['required', 'numeric'],
            'tien_lai' => ['nullable', 'numeric'],
            'trang_thai_hop_dong' => ['nullable', 'string'],
            'trang_thai' => ['required', 'integer'],
        ]);

        $data = [
            'ten_mon_hang' => $request->ten_mon_hang,
            'hinh_anh_mon_hang' => $imageName,
            'mo_ta' => $request->mo_ta,
            'nguoi_cam' => $request->nguoi_cam,
            'so_dien_thoai' => $request->so_dien_thoai,
            'so_cmnd' => $request->so_cmnd,
            'ngay_cam' => $request->ngay_cam,
            'ngay_het_han_cam' => $request->ngay_het_han_cam,
            'lai_suat' => $request->lai_suat,
            'so_tien_cam' => $request->so_tien_cam,
            'tien_lai' => $request->tien_lai,
            'trang_thai_hop_dong' => $request->trang_thai_hop_dong,
            'trang_thai' => $request->trang_thai,
        ];

        HopDongCamDo::updateOrCreate(['id' => $request->id], $data);

        return response()->json(['success' => 'Lưu Thành Công.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hopDongCamDo = HopDongCamDo::find($id);
        return response()->json($hopDongCamDo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        HopDongCamDo::where('id', $id)->update(['trang_thai' => 0]);
        return response()->json(['success' => 'Xóa Hợp Đồng Thành Công.']);
    }
    public function restore($id)
    {
        HopDongCamDo::where('id', $id)->update(['trang_thai' => 1]);
        return response()->json(['success' => 'Khôi phục Hợp Đồng Thành Công.']);
    }

}