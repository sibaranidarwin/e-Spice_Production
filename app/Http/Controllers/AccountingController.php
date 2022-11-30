<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BA_Reconcile;
use App\Draft_BA;
use App\User;
use App\Imports\Draft_BAImport;
use App\good_receipt;
use App\Invoice;


use Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AccountingController extends Controller
{
    // //
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $users = User::first()->paginate(10);
        return view('admin.accounting.index', compact('users'))
                ->with('i',(request()->input('page', 1) -1) *5);
    }
    public function index2()
    {
        {
            $good_receipt = good_receipt::count();
            $invoicegr = Invoice::all()->where("data_from", "GR")->count();
            $invoiceba = Invoice::all()->where("data_from", "BA")->count();
            $dispute = good_receipt::all()->where("Status", "Dispute")->count();
            $vendor = User::all()->where("level", "vendor")->count();
            $draft = Draft_BA::count();
            $ba = BA_Reconcile::count();
    
            return view('accounting.dashboard',['good_receipt'=>$good_receipt,'draft'=>$draft, 'ba'=>$ba , 'invoicegr'=>$invoicegr, 'invoiceba'=>$invoiceba, 'dispute'=>$dispute, 'vendor'=>$vendor]);
        }
    }

    public function po()
    {   
        $good_receipts = good_receipt::where("Status","Not Verified")->orWhere("Status"," ")->get();
        $dispute = good_receipt::all()->where("Status", "Dispute")->count();

        return view('accounting.po.index',compact('good_receipts', 'dispute'))
                ->with('i',(request()->input('page', 1) -1) *5);
    }
    public function pover(){
        $good_receipts = good_receipt::where("Status","Verified")->get();
        $dispute = good_receipt::all()->where("Status", "Dispute")->count();

        return view('accounting.po.verified',compact('good_receipts', 'dispute'))
        ->with('i',(request()->input('page', 1) -1) *5);
    }
    public function poreject(){
        $good_receipts = good_receipt::where("Status","Reject")->get();
        $dispute = good_receipt::all()->where("Status", "Dispute")->count();

        return view('accounting.po.reject',compact('good_receipts', 'dispute'))
        ->with('i',(request()->input('page', 1) -1) *5);
    }

    public function draft()
    {
    $draft = Draft_BA::all();
    return view('accounting.ba.draft',compact('draft'));
    }


    public function ba()
    {
        $ba = BA_Reconcile::all();
        
        return view('accounting.ba.upload',compact('ba'));
    }
    
    public function uploaddraft(Request $request)
    {
        $file = $request->file('excel-vendor-ba');
        Excel::import(new Draft_BAImport, $file);
        
        return back()->with('success', 'BA Imported Successfully');
    }
    public function disputed()
    {
        $good_receipts = good_receipt::where("Status", "Dispute")->get();
        return view('accounting.dispute.index',compact('good_receipts'))
                ->with('i',(request()->input('page', 1) -1) *5);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Masyarakat $user)
    {
        $fotoLama = $request->fotoLama;
            $foto = $request->file('foto');
            if(!empty($foto)){
                $foto = $request->file('foto');
                $namaBaru = Carbon::now()->timestamp . '_' . '.' . $foto->getClientOriginalExtension();
                $foto->move(public_path('upload/'),$namaBaru);
            }else{
                $foto = $fotoLama;
                $namaBaru = $foto;
            }

               Profile::whereId($user->id)->update([
                "nik"     => $request->nike,
                "name"     => $request->name,
                "telp"     => $request->telp,
                'email'     => $request->email,
                "foto"        => $namaBaru,
                ]);  
       return redirect ('admin/masyarakat')->with('success','Data Has Been Update');
    }

    public function invoice(){
        $invoice = Invoice::latest()->get();
        return view('accounting.invoice.index',compact('invoice'))
                ->with('i',(request()->input('page', 1) -1) *5);
   }
   public function detailinvoice(Request $request, $id){
        $detail = Invoice::find($id);
        $invoices = good_receipt::select("goods_receipt.id_gr",
                                    "goods_receipt.no_po",
                                    "goods_receipt.gr_number",
                                    "goods_receipt.po_item",
                                    "goods_receipt.gr_date",
                                    "goods_receipt.material_number",
                                    "goods_receipt.harga_satuan",
                                    "goods_receipt.jumlah",
                                    "goods_receipt.tax_code",
                                    "goods_receipt.status",
                                    "invoice.id_inv", 
                                    "invoice.posting_date", 
                                    "invoice.baselinedate",
                                    "invoice.no_invoice_proposal",
                                    "invoice.vendor_invoice_number",
                                    "invoice.faktur_pajak_number",
                                    "invoice.total_harga_everify",
                                    "invoice.ppn",
                                    "invoice.del_costs",
                                    "invoice.total_harga_gross",
                                    "invoice.created_at"
                                    )
                                    ->JOIN("invoice", "goods_receipt.id_inv", "=", "invoice.id_inv")
                                    ->where("invoice.id_inv", "=", "$detail->id_inv")
                                    ->get();

    return view('accounting.invoice.detail', compact('invoices'))->with('i',(request()->input('page', 1) -1) *5);
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return back()
                ->with('destroy','1 User Telah Di Hapus.');
    }
    public function showing($id){
        $user = \App\User::find($id);
        return view('accounting.user.profile',compact('user'));  
    }
    public function profile($id){
        $user = \App\Masyarakat::find($id);
        return view('admin.masyarakat.ubah-masyarakat',compact('user'));  
    }
}
