import Link from "next/link"
import { Star, Heart } from "lucide-react"
import { Button } from "@/components/ui/button"

const products = [
  {
    id: 1,
    name: "Jeans Slim Fit Classic",
    price: 899000,
    originalPrice: 1200000,
    rating: 4.8,
    reviews: 124,
    image: "/slim-fit-jeans.png",
    badge: "Bán chạy",
  },
  {
    id: 2,
    name: "Jeans Straight Vintage",
    price: 1299000,
    originalPrice: null,
    rating: 4.9,
    reviews: 89,
    image: "/placeholder-6pfbi.png",
    badge: "Mới",
  },
  {
    id: 3,
    name: "Jeans Skinny Premium",
    price: 1599000,
    originalPrice: 1899000,
    rating: 4.7,
    reviews: 156,
    image: "/placeholder-b8btn.png",
    badge: "Giảm giá",
  },
  {
    id: 4,
    name: "Jeans Wide Leg Modern",
    price: 1099000,
    originalPrice: null,
    rating: 4.6,
    reviews: 67,
    image: "/placeholder-2yzab.png",
    badge: null,
  },
]

export default function FeaturedProducts() {
  const formatPrice = (price: number) => {
    return new Intl.NumberFormat("vi-VN", {
      style: "currency",
      currency: "VND",
    }).format(price)
  }

  return (
    <section className="py-16 bg-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-12">
          <h2 className="font-serif text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Sản Phẩm Nổi Bật</h2>
          <p className="text-lg text-gray-600 max-w-2xl mx-auto">
            Những mẫu quần jeans được yêu thích nhất với chất lượng cao và thiết kế thời trang
          </p>
        </div>

        <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
          {products.map((product) => (
            <div
              key={product.id}
              className="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300"
            >
              <div className="relative aspect-[3/4] overflow-hidden">
                <img
                  src={product.image || "/placeholder.svg"}
                  alt={product.name}
                  className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                />

                {product.badge && (
                  <div className="absolute top-3 left-3">
                    <span
                      className={`px-2 py-1 text-xs font-semibold rounded-full ${
                        product.badge === "Bán chạy"
                          ? "bg-red-100 text-red-800"
                          : product.badge === "Mới"
                            ? "bg-green-100 text-green-800"
                            : "bg-orange-100 text-orange-800"
                      }`}
                    >
                      {product.badge}
                    </span>
                  </div>
                )}

                <Button
                  variant="ghost"
                  size="sm"
                  className="absolute top-3 right-3 bg-white/80 hover:bg-white opacity-0 group-hover:opacity-100 transition-opacity"
                >
                  <Heart className="w-4 h-4" />
                </Button>
              </div>

              <div className="p-4 space-y-3">
                <div>
                  <h3 className="font-semibold text-gray-900 mb-1 line-clamp-2">{product.name}</h3>
                  <div className="flex items-center space-x-1 mb-2">
                    <div className="flex items-center">
                      {[...Array(5)].map((_, i) => (
                        <Star
                          key={i}
                          className={`w-3 h-3 ${
                            i < Math.floor(product.rating) ? "text-yellow-400 fill-current" : "text-gray-300"
                          }`}
                        />
                      ))}
                    </div>
                    <span className="text-xs text-gray-600">({product.reviews})</span>
                  </div>
                </div>

                <div className="flex items-center justify-between">
                  <div className="space-y-1">
                    <div className="flex items-center space-x-2">
                      <span className="font-bold text-indigo-600">{formatPrice(product.price)}</span>
                      {product.originalPrice && (
                        <span className="text-sm text-gray-500 line-through">{formatPrice(product.originalPrice)}</span>
                      )}
                    </div>
                  </div>
                </div>

                <Button asChild className="w-full bg-indigo-600 hover:bg-indigo-700">
                  <Link href={`/products/${product.id}`}>Xem chi tiết</Link>
                </Button>
              </div>
            </div>
          ))}
        </div>

        <div className="text-center mt-12">
          <Button asChild variant="outline" size="lg">
            <Link href="/products">Xem tất cả sản phẩm</Link>
          </Button>
        </div>
      </div>
    </section>
  )
}
