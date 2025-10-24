import Link from "next/link"

const categories = [
  {
    id: 1,
    name: "Jeans Nam",
    description: "Phong cách mạnh mẽ, năng động",
    image: "/mens-jeans-collection.png",
    href: "/categories/mens-jeans",
  },
  {
    id: 2,
    name: "Jeans Nữ",
    description: "Thanh lịch, thời trang",
    image: "/womens-jeans-collection.png",
    href: "/categories/womens-jeans",
  },
  {
    id: 3,
    name: "Jeans Trẻ em",
    description: "Thoải mái, an toàn",
    image: "/kids-jeans-collection.png",
    href: "/categories/kids-jeans",
  },
]

export default function Categories() {
  return (
    <section className="py-16 bg-gray-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-12">
          <h2 className="font-serif text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Danh Mục Sản Phẩm</h2>
          <p className="text-lg text-gray-600 max-w-2xl mx-auto">
            Khám phá các bộ sưu tập jeans đa dạng dành cho mọi lứa tuổi và phong cách
          </p>
        </div>

        <div className="grid md:grid-cols-3 gap-8">
          {categories.map((category) => (
            <Link
              key={category.id}
              href={category.href}
              className="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
            >
              <div className="aspect-[4/3] overflow-hidden">
                <img
                  src={category.image || "/placeholder.svg"}
                  alt={category.name}
                  className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                />
              </div>
              <div className="p-6">
                <h3 className="font-serif text-xl font-bold text-gray-900 mb-2">{category.name}</h3>
                <p className="text-gray-600">{category.description}</p>
              </div>
            </Link>
          ))}
        </div>
      </div>
    </section>
  )
}
