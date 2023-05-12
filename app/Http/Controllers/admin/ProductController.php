<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function start()
    {
        $categories = $this->productService->getAllCategory();
        $manufacturers = $this->productService->getAllManufacturer();
        return view('admin.start', compact(
            'categories',
            'manufacturers',
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $pagination = $this->productService->showProducts($request);
        $categories = $this->productService->getAllCategory();
        $manufacturers = $this->productService->getAllManufacturer();
        return view('admin.index', compact(
            'user',
            'pagination',
            'categories',
            'manufacturers',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $categories = $this->productService->getAllCategory();
        $manufacturers = $this->productService->getAllManufacturer();
        return view('admin.add', compact(
            'categories',
            'manufacturers',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateProductRequest $request)
    {
        $this->productService->create($request);
        return redirect()->route('products.index')->with('success', 'Company created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $data = $this->productService->getById($id);
        $recommendedProducts = $this->productService->getRecommendedProducts($id);
        $categories = $this->productService->getAllCategory();
        $manufacturers = $this->productService->getAllManufacturer();
        return view('admin.show', compact(
            'data',
            'recommendedProducts',
            'categories',
            'manufacturers',
        ));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $product = $this->productService->getById($id);
        $categories = $this->productService->getAllCategory();
        $manufacturers = $this->productService->getAllManufacturer();
        $dataImages = $this->productService->getProductImages($id);
        return view('admin.update', compact(
            'dataImages',
            'product',
            'categories',
            'manufacturers',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $product = $this->productService->update($id, $request);
        return redirect()->route('products.index', $product->id)
            ->with([
                'successUpdate' => 'Company updated successfully.',
                'product_id' => $product->id,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->productService->delete($id);
        return redirect()->route('products.index')
            ->with('successDelete', 'Company has been deleted successfully');
    }
}
