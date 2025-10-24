import { Button } from "@/components/ui/button"
import Link from "next/link"

export default function BrandStory() {
  return (
    <section className="py-20 bg-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="grid lg:grid-cols-2 gap-12 items-center">
          <div className="space-y-6">
            <div className="space-y-4">
              <h2 className="font-serif text-3xl lg:text-4xl font-bold text-gray-900">Câu Chuyện Thương Hiệu</h2>
              <p className="text-lg text-gray-600 leading-relaxed">
                Từ năm 2010, chúng tôi đã cam kết mang đến những sản phẩm quần jeans chất lượng cao nhất với thiết kế
                hiện đại và phù hợp với phong cách Việt Nam.
              </p>
              <p className="text-gray-600 leading-relaxed">
                Với hơn 13 năm kinh nghiệm trong ngành thời trang, chúng tôi hiểu rõ nhu cầu và sở thích của khách hàng
                Việt. Mỗi sản phẩm đều được tuyển chọn kỹ lưỡng từ chất liệu đến thiết kế.
              </p>
            </div>

            <div className="flex flex-col sm:flex-row gap-4">
              <Button asChild size="lg" className="bg-indigo-600 hover:bg-indigo-700">
                <Link href="/about">Tìm hiểu thêm</Link>
              </Button>
              <Button asChild variant="outline" size="lg">
                <Link href="/contact">Liên hệ với chúng tôi</Link>
              </Button>
            </div>
          </div>

          <div className="relative">
            <div className="aspect-[4/3] bg-gradient-to-br from-indigo-100 to-blue-100 rounded-2xl overflow-hidden">
              <img src="/placeholder-zanis.png" alt="Cửa hàng quần jeans" className="w-full h-full object-cover" />
            </div>

            {/* Decorative elements */}
            <div className="absolute -top-6 -right-6 w-24 h-24 bg-indigo-600 rounded-full opacity-10"></div>
            <div className="absolute -bottom-6 -left-6 w-32 h-32 bg-blue-600 rounded-full opacity-10"></div>
          </div>
        </div>
      </div>
    </section>
  )
}
