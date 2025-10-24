import Link from "next/link"
import { Star, Heart } from "lucide-react"
import { Button } from "@/components/ui/button"

interface Product {
  id: number
  name: string
  price: number
  originalPrice?: number | null
  rating: number
  reviews: number
  image: string
  category: string
  size: string[]
  colors: string[]
}

interface ProductCardProps {
  product: Product
  viewMode?: "grid" | "list"
}

export default function ProductCard({ product, viewMode = "grid" }: ProductCardProps) {
  const formatPrice = (price: number) => {
    return new Intl.NumberFormat("vi-VN", {
      style: "currency",
      currency: "VND",
    }).format(price)
  }

  if (viewMode === "list") {
    return (
      <div className="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
        <div className="flex">
          <div className="w-48 h-48 flex-shrink-0">
            <img src={product.image || "/placeholder.svg"} alt={product.name} className="w-full h-full object-cover" />
          </div>
          <div className="flex-1 p-6 flex flex-col justify-between">
            <div>
              <div className="flex items-start justify-between mb-2">
                <h3 className="font-semibold text-lg text-gray-900">{product.name}</h3>
                <Button variant="ghost" size="sm">
                  <Heart className="w-4 h-4" />
                </Button>
              </div>

              <div className="flex items-center space-x-1 mb-3">
                <div className="flex items-center">
                  {[...Array(5)].map((_, i) => (
                    <Star
                      key={i}
                      className={`w-4 h-4 ${
                        i < Math.floor(product.rating) ? "text-yellow-400 fill-current" : "text-gray-300"
                      }`}
                    />
                  ))}
                </div>
                <span className="text-sm text-gray-600">({product.reviews} đánh giá)</span>
              </div>

              <div className="mb-4">
                <p className="text-sm text-gray-600 mb-2">
                  <span className="font-medium">Danh mục:</span> {product.category}
                </p>
                <p className="text-sm text-gray-600 mb-2">
                  <span className="font-medium">Size:</span> {product.size.join(", ")}
                </p>
                <p className="text-sm text-gray-600">
                  <span className="font-medium">Màu sắc:</span> {product.colors.join(", ")}
                </p>
              </div>
            </div>

            <div className="flex items-center justify-between">
              <div className="flex items-center space-x-2">
                <span className="font-bold text-xl text-indigo-600">{formatPrice(product.price)}</span>
                {product.originalPrice && (
                  <span className="text-sm text-gray-500 line-through">{formatPrice(product.originalPrice)}</span>
                )}
              </div>

              <Button asChild className="bg-indigo-600 hover:bg-indigo-700">
                <Link href={`/products/${product.id}`}>Xem chi tiết</Link>
              </Button>
            </div>
          </div>
        </div>
      </div>
    )
  }

  return (
    <div className="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300">
      <div className="relative aspect-[3/4] overflow-hidden">
        <img
          src={product.image || "/placeholder.svg"}
          alt={product.name}
          className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
        />

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
  )
}
