import Link from "next/link"
import { Button } from "@/components/ui/button"

export default function Hero() {
  return (
    <section className="relative bg-gradient-to-br from-indigo-50 to-blue-50 overflow-hidden">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
        <div className="grid lg:grid-cols-2 gap-12 items-center">
          <div className="space-y-8">
            <div className="space-y-4">
              <h1 className="font-serif text-4xl lg:text-6xl font-bold text-gray-900 leading-tight">
                Thời Trang Jeans
                <span className="text-indigo-600 block">Cao Cấp</span>
              </h1>
              <p className="text-lg text-gray-600 leading-relaxed max-w-lg">
                Khám phá bộ sưu tập quần jeans chất lượng cao với thiết kế hiện đại, phù hợp với mọi phong cách và dáng
                người.
              </p>
            </div>

            <div className="flex flex-col sm:flex-row gap-4">
              <Button asChild size="lg" className="bg-indigo-600 hover:bg-indigo-700">
                <Link href="/products">Mua sắm ngay</Link>
              </Button>
              <Button asChild variant="outline" size="lg">
                <Link href="/categories">Xem danh mục</Link>
              </Button>
            </div>

            <div className="flex items-center space-x-8 text-sm text-gray-600">
              <div className="flex items-center space-x-2">
                <div className="w-2 h-2 bg-green-500 rounded-full"></div>
                <span>Miễn phí vận chuyển</span>
              </div>
              <div className="flex items-center space-x-2">
                <div className="w-2 h-2 bg-blue-500 rounded-full"></div>
                <span>Đổi trả 30 ngày</span>
              </div>
            </div>
          </div>

          <div className="relative">
            <div className="aspect-square bg-gradient-to-br from-indigo-100 to-blue-100 rounded-2xl overflow-hidden">
              <img
                src="/stylish-jeans-collection.png"
                alt="Bộ sưu tập quần jeans"
                className="w-full h-full object-cover"
              />
            </div>

            {/* Floating cards */}
            <div className="absolute -top-4 -left-4 bg-white rounded-lg shadow-lg p-4 max-w-xs">
              <div className="flex items-center space-x-3">
                <div className="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                  <span className="text-indigo-600 font-bold">4.9</span>
                </div>
                <div>
                  <p className="font-semibold text-gray-900">Đánh giá cao</p>
                  <p className="text-sm text-gray-600">Từ 1000+ khách hàng</p>
                </div>
              </div>
            </div>

            <div className="absolute -bottom-4 -right-4 bg-white rounded-lg shadow-lg p-4">
              <div className="text-center">
                <p className="text-2xl font-bold text-indigo-600">50+</p>
                <p className="text-sm text-gray-600">Mẫu mã đa dạng</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  )
}
