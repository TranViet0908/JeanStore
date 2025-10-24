"use client"

import { useState } from "react"
import Header from "@/components/header"
import Footer from "@/components/footer"
import ProductCard from "@/components/product-card"
import { Button } from "@/components/ui/button"
import { Filter, Grid, List } from "lucide-react"

const products = [
  {
    id: 1,
    name: "Jeans Slim Fit Classic",
    price: 899000,
    originalPrice: 1200000,
    rating: 4.8,
    reviews: 124,
    image: "/slim-fit-jeans.png",
    category: "Nam",
    size: ["28", "30", "32", "34", "36"],
    colors: ["Xanh đậm", "Đen", "Xanh nhạt"],
  },
  {
    id: 2,
    name: "Jeans Straight Vintage",
    price: 1299000,
    originalPrice: null,
    rating: 4.9,
    reviews: 89,
    image: "/placeholder-6pfbi.png",
    category: "Nam",
    size: ["29", "31", "33", "35"],
    colors: ["Xanh vintage", "Nâu"],
  },
  {
    id: 3,
    name: "Jeans Skinny Premium",
    price: 1599000,
    originalPrice: 1899000,
    rating: 4.7,
    reviews: 156,
    image: "/placeholder-b8btn.png",
    category: "Nữ",
    size: ["25", "26", "27", "28", "29"],
    colors: ["Đen", "Xanh đậm"],
  },
  {
    id: 4,
    name: "Jeans Wide Leg Modern",
    price: 1099000,
    originalPrice: null,
    rating: 4.6,
    reviews: 67,
    image: "/placeholder-2yzab.png",
    category: "Nữ",
    size: ["24", "25", "26", "27", "28"],
    colors: ["Xanh nhạt", "Trắng"],
  },
  {
    id: 5,
    name: "Jeans Bootcut Retro",
    price: 1199000,
    originalPrice: null,
    rating: 4.5,
    reviews: 92,
    image: "/bootcut-retro-jeans.png",
    category: "Nam",
    size: ["30", "32", "34", "36", "38"],
    colors: ["Xanh đậm", "Đen"],
  },
  {
    id: 6,
    name: "Jeans High Waist Trendy",
    price: 1399000,
    originalPrice: 1699000,
    rating: 4.8,
    reviews: 203,
    image: "/placeholder-nyp1b.png",
    category: "Nữ",
    size: ["24", "25", "26", "27", "28", "29"],
    colors: ["Xanh đậm", "Đen", "Xanh nhạt"],
  },
]

const categories = ["Tất cả", "Nam", "Nữ", "Trẻ em"]
const priceRanges = [
  { label: "Dưới 1 triệu", min: 0, max: 1000000 },
  { label: "1 - 1.5 triệu", min: 1000000, max: 1500000 },
  { label: "1.5 - 2 triệu", min: 1500000, max: 2000000 },
  { label: "Trên 2 triệu", min: 2000000, max: Number.POSITIVE_INFINITY },
]

export default function ProductsPage() {
  const [selectedCategory, setSelectedCategory] = useState("Tất cả")
  const [selectedPriceRange, setSelectedPriceRange] = useState<any>(null)
  const [viewMode, setViewMode] = useState<"grid" | "list">("grid")
  const [showFilters, setShowFilters] = useState(false)

  const filteredProducts = products.filter((product) => {
    const categoryMatch = selectedCategory === "Tất cả" || product.category === selectedCategory
    const priceMatch =
      !selectedPriceRange || (product.price >= selectedPriceRange.min && product.price <= selectedPriceRange.max)

    return categoryMatch && priceMatch
  })

  return (
    <div className="min-h-screen bg-gray-50">
      <Header />

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {/* Page Header */}
        <div className="mb-8">
          <h1 className="font-serif text-3xl font-bold text-gray-900 mb-2">Tất cả sản phẩm</h1>
          <p className="text-gray-600">Khám phá bộ sưu tập quần jeans đa dạng với nhiều phong cách khác nhau</p>
        </div>

        <div className="flex flex-col lg:flex-row gap-8">
          {/* Filters Sidebar */}
          <div className={`lg:w-64 ${showFilters ? "block" : "hidden lg:block"}`}>
            <div className="bg-white rounded-lg shadow-sm p-6 space-y-6">
              <h3 className="font-semibold text-lg text-gray-900">Bộ lọc</h3>

              {/* Category Filter */}
              <div>
                <h4 className="font-medium text-gray-900 mb-3">Danh mục</h4>
                <div className="space-y-2">
                  {categories.map((category) => (
                    <label key={category} className="flex items-center">
                      <input
                        type="radio"
                        name="category"
                        value={category}
                        checked={selectedCategory === category}
                        onChange={(e) => setSelectedCategory(e.target.value)}
                        className="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                      />
                      <span className="ml-2 text-sm text-gray-700">{category}</span>
                    </label>
                  ))}
                </div>
              </div>

              {/* Price Filter */}
              <div>
                <h4 className="font-medium text-gray-900 mb-3">Khoảng giá</h4>
                <div className="space-y-2">
                  <label className="flex items-center">
                    <input
                      type="radio"
                      name="price"
                      checked={!selectedPriceRange}
                      onChange={() => setSelectedPriceRange(null)}
                      className="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                    />
                    <span className="ml-2 text-sm text-gray-700">Tất cả</span>
                  </label>
                  {priceRanges.map((range, index) => (
                    <label key={index} className="flex items-center">
                      <input
                        type="radio"
                        name="price"
                        checked={selectedPriceRange === range}
                        onChange={() => setSelectedPriceRange(range)}
                        className="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                      />
                      <span className="ml-2 text-sm text-gray-700">{range.label}</span>
                    </label>
                  ))}
                </div>
              </div>
            </div>
          </div>

          {/* Products Grid */}
          <div className="flex-1">
            {/* Toolbar */}
            <div className="flex items-center justify-between mb-6">
              <div className="flex items-center space-x-4">
                <Button variant="outline" size="sm" onClick={() => setShowFilters(!showFilters)} className="lg:hidden">
                  <Filter className="w-4 h-4 mr-2" />
                  Bộ lọc
                </Button>
                <span className="text-sm text-gray-600">{filteredProducts.length} sản phẩm</span>
              </div>

              <div className="flex items-center space-x-2">
                <Button
                  variant={viewMode === "grid" ? "default" : "outline"}
                  size="sm"
                  onClick={() => setViewMode("grid")}
                >
                  <Grid className="w-4 h-4" />
                </Button>
                <Button
                  variant={viewMode === "list" ? "default" : "outline"}
                  size="sm"
                  onClick={() => setViewMode("list")}
                >
                  <List className="w-4 h-4" />
                </Button>
              </div>
            </div>

            {/* Products */}
            <div className={`grid gap-6 ${viewMode === "grid" ? "sm:grid-cols-2 lg:grid-cols-3" : "grid-cols-1"}`}>
              {filteredProducts.map((product) => (
                <ProductCard key={product.id} product={product} viewMode={viewMode} />
              ))}
            </div>

            {filteredProducts.length === 0 && (
              <div className="text-center py-12">
                <p className="text-gray-500">Không tìm thấy sản phẩm nào phù hợp với bộ lọc.</p>
              </div>
            )}
          </div>
        </div>
      </div>

      <Footer />
    </div>
  )
}
