<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Establishment;
use App\Models\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EstablishmentController extends Controller
{
    public function index(Request $request)
    {
        $vendor = Auth::guard('vendor')->user();
        $query = Establishment::where('vendor_id', $vendor->id)->with(['category']);

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('cidade', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $status = $request->status === 'active';
            $query->where('ativo', $status);
        }

        // Ordenação
        $orderBy = $request->order_by ?? 'id';
        $orderDirection = 'asc';

        if ($orderBy === 'created_at') {
            $orderDirection = 'desc';
        }

        $query->orderBy($orderBy, $orderDirection);

        $establishments = $query->paginate(10)->withQueryString();
        $categories = Category::orderBy('nome')->get();

        // TODO: Create this view
        return view('vendor.establishments.index', compact('establishments', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('nome')->get();
        $qrCodes = QrCode::orderBy('id')->get(); // Assuming vendors can assign QR codes too
        // TODO: Create this view
        return view('vendor.establishments.create', compact('categories', 'qrCodes'));
    }

    public function store(Request $request)
    {
        $vendor = Auth::guard('vendor')->user();
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nome' => 'required|string|max:255',
            'cnpj' => 'nullable|string|max:18',
            'endereco' => 'required|string|max:255',
            'cep' => 'required|string|max:9',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|string|size:2',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:establishments,email',
            'ativo' => 'boolean',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:15360',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:15360',
            'qr_codes' => 'array',
            'qr_codes.*' => 'exists:qr_codes,id'
        ]);

        if (isset($validated['cnpj'])) {
            $validated['cnpj'] = preg_replace('/[^0-9]/', '', $validated['cnpj']);
        }

        $validated['ativo'] = $request->has('ativo');
        $validated['vendor_id'] = $vendor->id; // Assign current vendor

        $fileData = [];
        if ($request->hasFile('logo')) {
            $fileData['logo'] = $request->file('logo');
            unset($validated['logo']);
        }
        if ($request->hasFile('image')) {
            $fileData['image'] = $request->file('image');
            unset($validated['image']);
        }

        $establishment = Establishment::create($validated);

        if (isset($fileData['logo'])) {
            $filename = "{$establishment->id}_" . now()->format('YmdHis') . '.' . $fileData['logo']->getClientOriginalExtension();
            $path = $fileData['logo']->storeAs(
                'establishments/logos',
                $filename,
                'public'
            );
            $establishment->logo = $path;
        }

        if (isset($fileData['image'])) {
            $filename = "{$establishment->id}_" . now()->format('YmdHis') . '.' . $fileData['image']->getClientOriginalExtension();
            $path = $fileData['image']->storeAs(
                'establishments/images',
                $filename,
                'public'
            );
            $establishment->image = $path;
        }

        if (!empty($fileData)) {
            $establishment->save();
        }

        if ($request->has('qr_codes')) {
            $establishment->qrCodes()->sync($request->qr_codes);
        }

        return redirect()->route('vendor.establishments.index') // TODO: Define this route
            ->with('success', 'Estabelecimento criado com sucesso!');
    }

    public function edit(Establishment $establishment)
    {
        $vendor = Auth::guard('vendor')->user();
        // Ensure the establishment belongs to the authenticated vendor
        if ($establishment->vendor_id !== $vendor->id) {
            abort(403, 'Acesso não autorizado.');
        }

        $categories = Category::orderBy('nome')->get();
        $qrCodes = QrCode::orderBy('id')->get();
        // TODO: Create this view
        return view('vendor.establishments.edit', compact('establishment', 'categories', 'qrCodes'));
    }

    public function update(Request $request, Establishment $establishment)
    {
        $vendor = Auth::guard('vendor')->user();
        // Ensure the establishment belongs to the authenticated vendor
        if ($establishment->vendor_id !== $vendor->id) {
            abort(403, 'Acesso não autorizado.');
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nome' => 'required|string|max:255',
            'cnpj' => 'nullable|string|max:18',
            'endereco' => 'required|string|max:255',
            'cep' => 'required|string|max:9',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|string|size:2',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:establishments,email,' . $establishment->id,
            'ativo' => 'boolean',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:15360',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:15360',
            'qr_codes' => 'array',
            'qr_codes.*' => 'exists:qr_codes,id'
        ]);

        if (isset($validated['cnpj'])) {
            $validated['cnpj'] = preg_replace('/[^0-9]/', '', $validated['cnpj']);
        } else {
            $validated['cnpj'] = null;
        }

        $validated['ativo'] = $request->has('ativo');
        // vendor_id does not change on update

        if ($request->hasFile('logo')) {
            if ($establishment->logo) {
                Storage::disk('public')->delete($establishment->logo);
            }
            $filename = "{$establishment->id}_" . now()->format('YmdHis') . '.' . $request->file('logo')->getClientOriginalExtension();
            $path = $request->file('logo')->storeAs(
                'establishments/logos',
                $filename,
                'public'
            );
            $validated['logo'] = $path;
        } else {
            unset($validated['logo']); // Ensure logo is not nulled if not provided and no new file uploaded
        }

        if ($request->hasFile('image')) {
            if ($establishment->image) {
                Storage::disk('public')->delete($establishment->image);
            }
            $filename = "{$establishment->id}_" . now()->format('YmdHis') . '.' . $request->file('image')->getClientOriginalExtension();
            $path = $request->file('image')->storeAs(
                'establishments/images',
                $filename,
                'public'
            );
            $validated['image'] = $path;
        } else {
            unset($validated['image']); // Ensure image is not nulled if not provided
        }

        $establishment->update($validated);

        if ($request->has('qr_codes')) {
            $establishment->qrCodes()->sync($request->qr_codes);
        } else {
            $establishment->qrCodes()->detach();
        }

        return redirect()->route('vendor.establishments.index') // TODO: Define this route
            ->with('success', 'Estabelecimento atualizado com sucesso!');
    }

    public function destroy(Establishment $establishment)
    {
        $vendor = Auth::guard('vendor')->user();
        // Ensure the establishment belongs to the authenticated vendor
        if ($establishment->vendor_id !== $vendor->id) {
            abort(403, 'Acesso não autorizado.');
        }

        if ($establishment->logo) {
            Storage::disk('public')->delete($establishment->logo);
        }
        if ($establishment->image) {
            Storage::disk('public')->delete($establishment->image);
        }
        $establishment->qrCodes()->detach();
        $establishment->delete();

        return redirect()->route('vendor.establishments.index') // TODO: Define this route
            ->with('success', 'Estabelecimento excluído com sucesso!');
    }
}
